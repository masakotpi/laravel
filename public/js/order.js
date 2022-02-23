
$(function(){
    //初期化
    const products_list = products;
    const makers = maker_list;
    $( function() {
        $( "#sortable" ).sortable();
        $( "#sortable" ).disableSelection();
      } );
    
    $('#bulk-check-action').on('click', function() {
        if(!$(this).prop('checked')){
            $('.each_ids').prop('checked',false);
        }else{
            $('.each_ids').prop('checked',true);
        }
    })

    $('[name=product_id]').on('change', function () {
        let product_id = $(this).val();
         // product_idから商品情報を検索
        var selected_product = $.grep(products_list,function(product, index) {
            return (product.id == product_id);
            }
        );
        $('[name=maker_id]').val(selected_product[0].maker_id);
        $('[name=maker_name]').val(makers[selected_product[0].maker_id]);
        $('[name=color]').val(selected_product[0].color);
        $('[name=size]').val(selected_product[0].size);
        $('[name=per_case]').val(selected_product[0].per_case);
        $('[name=purchase_price]').val(selected_product[0].purchase_price);
      
    })

    




    
});

