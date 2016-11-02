/**
 * Created by sometimes on 2016/10/31.
 */

var keys = [];
/**
 * 数组去重复
 * @returns {*[]}
 */
Array.prototype.unique4 = function()
{
    this.sort();
    var re=[this[0]];
    for(var i = 1; i < this.length; i++)
    {
        if( this[i] !== re[re.length-1])
        {
            re.push(this[i]);
        }
    }
    return re;
};
/**
 * 去除空格
 * @returns {string}
 */
String.prototype.trim = function() {
    return this.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
};
$(function() {
    $('#tagKeys').tagsInput({width:'auto',height:'auto'});
    $('#submitKeys').on('click',function(){
        console.log(1);
        $("#tagKeys_tagsinput span.tag").each(function(){
            var key = $(this).find("span").text();
            keys.push(key.trim());
        });
        console.log(keys);
        return false;
    });
});