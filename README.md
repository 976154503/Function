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



