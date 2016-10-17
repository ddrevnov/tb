let Services = (function() {

  let $table = $('.table--sortable');
  let $sortBlock = $table.find('.sortable');

  function init() {
    $sortBlock.sortable({
      axis: 'y',
      update: function (event, ui) {
          // let sorted = $(this).sortable('serialize');
          let sorted = $sortBlock.sortable( "serialize", { key: "sort" } );

          console.log(sorted);

          // POST to server using $.post or $.ajax
          // $.ajax({
          //     data: data,
          //     type: 'POST',
          //     url: '/your/url/here'
          // });
      }
    });
  }

  return {
    init
  }

})();

export default Services;
