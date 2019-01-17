## js面试题目总结

+ 数组去重
  
```javascript

var arr = [1,1,1,1,2,,3,4,4,5,7,2,8];
Array.prototype.unique = function (){
    var newArr = [];
    var obj = {};
    for( var i = 0;i < this.length; i++){
        if(!obj[this[i]]){
            obj[this[i]] = 'test';
            newArr.push(this[i]);
        }
    }
    return newArr;
}
var result = arr.unique();
console.log(result);

//运行结果
[1, 2, undefined, 3, 4, 5, 7, 8]

```

+ 原生js实现事件代理/事件委托

```javascript
    <div id="dom"><a>测试元素</a></div>

    function delegateEvent(interfaceEle, selector, eventType, fn){
        if(interfaceEle.addEventListener){
            interfaceEle.addEventListener(eventType,eventfn);
        }else{
            interfaceEle.attachEvent('on' + eventType,eventfn);
        }
        function eventfn(e){
            var e = e || window.event;
            var target = e.target || e.srcElement;
            if(matchSelector(target,selector)){
                if(fn){
                    fn.call(target,eventType);
                }
            }
        }
        function matchSelector(interfaceEle,selector){
            if(selector.charAt(0) === '#'){
                return interfaceEle.id === selector.slice(1);
            }
            if(selector.charAt(0) === '.'){
                return (interfaceEle.className).indexOf(selector.slice(1)) != -1;
            }
            return interfaceEle.tagName.toLowerCase() === selector.toLowerCase();
        }
    }

    var document.getElementById('dom');
    delegateEvent(dom, 'a', 'click', function(){
        alert(1);
    });
```

+ 对某一个事件名称绑定多个事件响应函数，触发事件名称时，依次按绑定顺序触发相应的响应函数。
```javascript
//方法一
function Event(){
    this.events = {}
}
Event.prototype = {
    constructor: Event,
    addEvent: function(typeName,fn){
        if(typeof this.events[typeName] === 'undefined'){
            this.events[typeName] = [];
        }
        this.events[typeName].push(fn);
    },
    dispatchEvent: function(event){
        if(!event.target){
            event.target = this;
        }
        if(this.events[event.typeName] instanceof Array){
            var handlers = this.events[event.typeName];
            for(var i = 0; i < handlers.length; i++){
                handlers[i](event);
            }
        }
    },
    removeEvent: function(type,fn){
        if(this.events[type] instanceof Array){
            var handlers = this.events[type];
            for(var i = 0; i < handlers.length; i++){
                if(handlers[i] == fn){
                    this.events[type].splice(i,1);
                    break;
                }
            }
        }
        return this;
    }
}

var tag = new Event();
var fun01 = function(){
    console.log(1);
}
var fun02 = function(){
    console.log(2);
}
tag.addEvent('play',fun01);
tag.addEvent('play',fun02);
tag.dispatchEvent({type:'play'});

//方法二
var createEvent = new Event();
createEvent.addEvent('play',function(){
    alert('1');
});
createEvent.showEvent('play','fn1','fn2');
function Event(){
    this.events = {}
}
Event.prototype = {
    contructor: Event,
    addEvent: function(eventName, fn){
        var fnArr = this.events[eventName] ? this.events[eventName] : [];
        fnArr.push(fn);
        this.events[eventName] = fnArr;
    },
    showEvent: function(eventName){
        if(!this.events.hasOwnProperty(eventName)){
            return;
        }
        var fnArr = this.events[eventName];
        if(!Array.isArray(fnArr)){
            return;
        }
        var args = Array.prototype.slice.call(arguments,1);
        var _this = this;
        fnArr.forEach(function(fn){
            try{
                fn.call(_this,args)
            }catch(e){
                console.log(e);
            }
        })
    }
}
```

