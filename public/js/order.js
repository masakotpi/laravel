
$(function(){
    //初期化
    const products_list = products;
    const makers = maker_list;
    $( function() {
        $( ".sortable" ).sortable({ items: '> tr:not(.unsortable)' });
        $( ".sortable" ).sortable({
            update: function(arrival,ui){
               let moved_tr = ui.item;
               let arrival_date = moved_tr.prevAll('.arrival_date').data('date');//新しく変更
               moved_tr.attr('data-date',arrival_date);
               moved_tr.find('.order_by').attr('name','order_by['+arrival_date+'][]');
            }
        });
        $( ".sortable" ).disableSelection();
      });
    
    //一括選択
    $('#bulk-check-action').on('click', function() {
        if(!$(this).prop('checked')){
            $('.each_ids').prop('checked',false);
        }else{
            $('.each_ids').prop('checked',true);
        }
    })

    //新規登録：商品検索
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


    //更新
    $('.update').on('click', function () {
        let order = $(this).data('data');
        $('.order_update').attr('formaction','orders/'+order.id);
        $('[name=order_number]').val(order.order_number);
        $('[name=product_id]').val(order.product_id);
        $('[name=expected_arrival_date]').val(order.expected_arrival_date);
        $('[name=product_name]').val(order.product_name);
        $('[name=quantity]').val(order.quantity);
        $('[name=maker_id]').val(order.maker_id);
        $('[name=maker_name]').val(makers[order.maker_id]);
        $('[name=color]').val(order.color);
        $('[name=size]').val(order.size);
        $('[name=per_case]').val(order.per_case);
        $('[name=purchase_price]').val(order.purchase_price);
    })


    //入荷予定日変更
    $('[name=arrival_date]').on('change', function () {
        let new_arrival_date = $(this).val();
        let old_arrival_date = $(this).closest('tr').data('date');
        $('[data-date='+old_arrival_date+']').find('.order_by').attr('name','order_by['+new_arrival_date+'][]');
        $('[data-date='+old_arrival_date+']').attr('data-date',new_arrival_date);
       
    })



    
});

