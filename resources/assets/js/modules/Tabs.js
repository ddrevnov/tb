let Tabs = (function() {

  function init() {
    let $blockItem = $('.block__item');
    $blockItem.click(function(){
      let $this = $(this);
      let $block = $this.closest('.block');
      let tab_id = $this.attr('data-tab');

      $block.find('.block__item').removeClass('is-active');
      $this.addClass('is-active');

      $block.children('.tab-content').removeClass('is-active');
      // $("#"+tab_id).addClass('is-active');
      $block.find(`[data-tab-id=${tab_id}]`).addClass('is-active');

      $this
        .closest('.block').find('.block')
        .find('.block__item:first').addClass('is-active');
    });
  }
  return {
    init
  }

})();

export default Tabs;
