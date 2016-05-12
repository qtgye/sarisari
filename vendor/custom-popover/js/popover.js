/**
 *
 *  THE PLUGIN
 *  
 */

 ;(function (_w,_d) {
     

    Plugin = _w.Popover = _w.Popover || {};
    // Bail early if already defined
    if (Plugin.isInitialized) return;

    /**
     * PRIVATE VARS
     */
    var scrollBarWidth = 0;    


    /**
     * SETUP INITIAL PROPS
     */
    Plugin.items = [];
    Plugin.itemsMap = {};
    Plugin.itemGroups = [];
    Plugin.itemGroupsMap = {};


    /**
     * DEFINE TEMPLATES
     */


     /**
      * MODAL OBJECT
      */
    var Modal = (function () {
        
        var _modal = {};

        var template = '<div class="js-image-popup-modal">' + 
                            '<div class="popup-overlay"></div>' + 
                            '<div class="popup-dialog">' + 
                                '<span class="popup-arrow left">&lt;</span>'+
                                '<span class="popup-arrow right">&gt;</span>'+
                                '<div class="popup-content">'+ 
                                '</div>' + 
                            '</div>' + 
                        '</div>',
            parser = new DOMParser(),
            doc = parser.parseFromString(template, "text/html"),
            modalElement = doc.getElementsByClassName('js-image-popup-modal')[0];

        // UPDATE PROPS
        _modal.DOM = {
            element : modalElement,
            overlay : modalElement.getElementsByClassName('popup-overlay')[0],
            dialog : modalElement.getElementsByClassName('popup-dialog')[0],
            content : modalElement.getElementsByClassName('popup-content')[0],
            arrows : {
                previous : modalElement.getElementsByClassName('popup-arrow left')[0],
                next : modalElement.getElementsByClassName('popup-arrow right')[0]
            }
        };
        _modal.isVisible = false;

        // METHODS

        /**
         * shows the modal
         * @param  {object} callbacks { beforeShow : fn, onShow : fn }
         * @return {void}
         */
        _modal.show = function (callbacks) {
            var content = _modal.content || _d.createElement('div');
            // prevent scroll
            _d.body.style['padding-right'] = scrollBarWidth + 'px';
            _d.body.style.overflow = 'hidden';
            // update modal content
            _modal.DOM.content.innerHTML = '';          
            _modal.DOM.content.appendChild(content);
            _d.body.appendChild(_modal.DOM.element);

            if ( callbacks && callbacks.beforeShow ) callbacks.beforeShow(_modal);

            setTimeout(function () {
                _modal.DOM.element.style.opacity = 1;
                _modal.isVisible = true;
                if ( callbacks && callbacks.onShow ) callbacks.onShow(_modal);
            },100);
        }

        /**
         * hides the modal
         * @param  {object} callbacks { beforeHide : fn, onHide : fn }
         * @return {[type]} [description]
         */
        _modal.hide = function (callbacks) {
            _modal.DOM.element.style.opacity = 0;
            if ( callbacks && callbacks.beforeHide ) callbacks.beforeHide(_modal);
            setTimeout(function () {
                _d.body.removeChild(_modal.DOM.element);
                // revert scroll
                _d.body.style['padding-right'] = '';
                _d.body.style.overflow = '';
                _modal.isVisible = false;
                if ( callbacks && callbacks.onHide ) callbacks.onHide(_modal);
            },500);
        }

        // BINDS

        _modal.DOM.overlay.addEventListener('click',_modal.hide,false);


        return _modal;

    })();

    Plugin.Modal = Modal;


    /**
     * POPOVER ITEM CLASS
     * @param {HTML Image} img an HTML Image Element
     */
    function Item (el) {

        var _item = this;

        if ( !(el instanceof HTMLImageElement) ) {
            var dataSrc = el.getAttribute('data-src');
            if ( dataSrc ) {
                var _img = new Image();
                _img.src = dataSrc;
                _d.body.appendChild(_img);
                _img.style.position = 'fixed';
                _img.style.visibility = 'hidden';
                _img.style.top = '-9999px';
            } else {
                // doesnt have src to work on
                console.log('no src');
                return;
            }
        } else {
            var _img = el;
        }           

        _item.image = {
            element : _img,
            src     : _img.src,
            alt     : _img.alt,
            title   : _img.title,
            height  : _img.height,
            width   : _img.width,
            HWRatio : _img.height/_img.width
        };
        _item.element = el;
        _item.title = _img.title || _img.getAttribute('data-title');
        _item.src = _img.getAttribute('data-src') || _img.src;
        _item.content = _img.getAttribute('data-content') || '';
        _item.id = Math.floor(Math.random()*Date.now() + 99999999);
        _item.events = {
            onActive : null,
            beforeShow : null,
            onShow : null
        };

        // SETUP GROUP IF GIVEN
        var groupName = el.getAttribute('data-popover-group') || false;

        if ( groupName ) { 
            if ( groupName in Plugin.itemGroupsMap ) {
                var itemGroup = Plugin.itemGroups[Plugin.itemGroupsMap[groupName]];
                itemGroup.addItem(_item);
            } else {
                _item.group = new Group(groupName,[_item]);
            }            
        }

        // PROPERTIES

        _item.show = function () {
            if ( _item.group ) {
                // show group focusing to this item
                _item.group.show(_item,_item.events);
            } else {
                // show this item
                var newImage = new Image;                
                newImage.src = _item.src;                
                Modal.content = newImage;
                Modal.show({
                    beforeShow : _item.events.beforeShow,
                    onShow : _item.events.onShow
                });
                // Hide modal arrows
                Modal.DOM.arrows.previous.style.display = 'none';
                Modal.DOM.arrows.next.style.display = 'none';
            }
        }

        // DOM UPDATES

        el.setAttribute('data-popover-item-id',_item.id);

        // BINDS
        el.addEventListener('click',_item.show,false);

        // ADD TO STORE
        var _index = Plugin.items.length;
        Plugin.items[_index] = _item;
        Plugin.itemsMap[_item.id] = _index;

    }


    /**
     * POPOVER GROUP CLASS
     * @param {Array} [items] An array of Item Object instances
     */
    function Group (name,items) {
        
        if ( !items || !items.length ) return;

        var _group = this,
            index = Plugin.itemGroups.length;
        Plugin.itemGroups[index] = _group;
        Plugin.itemGroupsMap[name] = index;

        // INITIAL PROPS
        _group.name = name;
        _group.currentIndex = false;
        _group.items = items;
        _group.itemsMap = {};

        // METHODS

        _group.setCurrent = function (_index) {
            _group.currentIndex = _index;
            _group.currentItem = _group.items[_index];

            if ( _index >= _group.items.length - 1 ) {
                // disable next
                Modal.DOM.arrows.next.style.display = 'none';
            } else {
                Modal.DOM.arrows.next.style.display = '';
            }

            if ( _index === 0 ) {
                // disable previous
                Modal.DOM.arrows.previous.style.display = 'none';
            } else {
                Modal.DOM.arrows.previous.style.display = '';
            }
        }

        _group.replaceImage = function (item) {
            var src = item.src,
                img = Modal.DOM.element.getElementsByTagName('img');
            if ( img.length ) {
                var newImage = new Image;                
                newImage.src = src;
                newImage.style.transition = 'opacity .3s ease';
                img = img[0];
                img.style.transition = 'opacity .3s ease';
                img.style.opacity = 0;
                setTimeout(function () {
                    img.parentElement.removeChild(img);                    
                    Modal.DOM.content.appendChild(newImage);
                    newImage.style.opacity = 1;
                    if ( item.onActive ) {
                        item.onActive(item,_group,Modal);
                    }
                },300);
            }
        }

        _group.addItem = function (_item) {
            if ( _item instanceof Item && !( _item.id in _group.itemsMap )  ) {
                var itemIndex = _group.items.length;
                _group.items[itemIndex] = _item;
                _group.itemsMap[_item.id] = itemIndex;
                _item.group = _group;
            }
        }

        _group.show = function (_item,callbacks) {
            var currentIndex = 0;
            // var itemId 
            if ( _item && _item.id in _group.itemsMap ) {
                for ( _id in _group.itemsMap ) {
                    if( _item.id == _id ) {
                        currentIndex = _group.itemsMap[_id];
                        break;
                    }
                }
            }
            _item = _group.items[currentIndex];
            var newImage = new Image;                
            newImage.src = _item.src;                
            Modal.content = newImage;
            Modal.show(callbacks);
            _group.setCurrent(currentIndex);

            // Bind modal arrows
            Modal.DOM.arrows.previous.addEventListener('click',_group.previous);
            Modal.DOM.arrows.next.addEventListener('click',_group.next);
        }

        _group.next = function () {
            if ( !_group.items[_group.currentIndex+1] || !Modal.isVisible ) return;
            _group.setCurrent(++_group.currentIndex);
            _group.replaceImage(_group.currentItem);
        }

        _group.previous = function () {
            if ( !_group.items[_group.currentIndex-1] || !Modal.isVisible ) return;
            _group.setCurrent(--_group.currentIndex);
            _group.replaceImage(_group.currentItem);
        }

        // INIT
        
        _group.items.forEach(function (_item,index) {
            _group.itemsMap[_item.id] = index;
        });

    }


    /**
     * PRIVATE FUNCTIONS
     */

    function getScrollBarWidth () {
        var outer = _d.createElement('div'),
            inner = _d.createElement('div');

        _d.body.appendChild(outer);
        outer.appendChild(inner);

        outer.style.overflow = 'scroll';
        outer.style.height = '200px';
        inner.style.height = '300px';

        var outerWidth = outer.getBoundingClientRect().width,
            innerWidth = inner.getBoundingClientRect().width;

        scrollBarWidth = Math.abs(outerWidth-innerWidth);
        outer.parentNode.removeChild(outer);
    }

    function bindImages () {
        var images = _d.getElementsByClassName('js-popover');
        [].forEach.call(images,function (image) {
            var _item = new Item(image);
            // console.log('_item',_item);
        });
    }


    /**
     * SETUP METHODS
     */

    Plugin.getItem = function (image) {
        if ( image instanceof HTMLImageElement ) {
            var id = image.getAttribute('data-popover-item-id');
            return ( id in Plugin.itemsMap ) ? Plugin.items[Plugin.itemsMap[id]] : null;
        }
        return null;
    }


    Plugin.getGroup = function (groupName) {
        if ( groupName in Plugin.itemGroupsMap ) {
            var index = Plugin.itemGroupsMap[groupName];
            return Plugin.itemGroups[index];
        }
        return null;
    };

    Plugin.show = function (itemId) {
        if ( !(itemId in Plugin.itemsMap) ) return;
        Plugin.items[Plugin.itemsMap[itemId]].show();
    };

    Plugin.init = function () {
        getScrollBarWidth();
        bindImages();
        Plugin.isInitialized = true;
    };
    

    // INIT

    if ( !Plugin.isInitialized ) {
        _d.addEventListener("DOMContentLoaded", Plugin.init);  
    }
    

 })(window,document);