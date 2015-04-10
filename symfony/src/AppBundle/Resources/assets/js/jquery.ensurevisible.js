/**
 * @author Adam Borowski
 * @param jqChild
 */
$.fn.ensureVisible = function (jqChild) {
  this.each(function () {
    var container = $(this);
    var rowpos = jqChild.position();
    var tableHeight = container.height();
    var currentScrollTop = container.scrollTop();
    var localTop = rowpos.top + currentScrollTop;
    var childHeight = jqChild.height();
    if (localTop >= currentScrollTop + tableHeight - childHeight) {
      container.scrollTop(localTop - tableHeight + childHeight);
    }
    else if (localTop < currentScrollTop) {
      container.scrollTop(localTop);
    }
  })
};