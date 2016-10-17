var Sidebar = (function() {

  /**
   * @return {[String]}
   */
  function showSubmenu() {
    var $sidebar = $('.sidebar');
    var $sidebarItem = $sidebar.find('.sidebar__item');
    $('.sidebar__submenu').hide();

    $sidebarItem.on({
      'mouseenter':function(){
        $(this).addClass('is-hover');
        $(this).find('.sidebar__submenu').show();
      },'mouseleave':function(){
        $(this).removeClass('is-hover');
        $(this).find('.sidebar__submenu').hide();
      }
    });

    return 'showMenu';
  }

  return {
    init: function() {
      showSubmenu();
    }
  }

})();

export default Sidebar;
