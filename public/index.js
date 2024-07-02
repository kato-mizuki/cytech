// テーブルソート機能
$(function(){
    $('.table').tablesorter();
  });

var csrfToken = $('meta[name="csrf-token"]').attr('content');

 $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault(); // デフォルトのクリック動作を防ぐ
        var id = $(this).closest('tr').data('id'); // tr要素からdata-idを取得
        var url = $(this).data('url');
        var row = $(this).closest('tr');
        console.log(id)
        console.log(url)

        if (id === undefined) {
            // IDが取得できない場合は処理を中断
            console.error("IDが取得できません。");
            return;
        }
        // Ajaxリクエストを送信
        $.ajax({
            type: 'POST', 
            url: 'delete/' + id,
            data: {
                _token: csrfToken,
                _method: 'DELETE' // LaravelでPOSTをDELETEリクエストとして処理する
            },
            //dataType: 'json',

            }).done(function(response) {
                // 成功時の処理
                alert(response.message);
                 // 画面から要素を削除
                row.hide();
                
            }).fail(function(xhr) {
                // エラー時の処理
                console.log(xhr); 
                alert('削除に失敗しました');
            })
            
        });
        
  // 非同期検索
  $(function() {
    $('#btnSearch').click(function(e){
      e.preventDefault(); 
      var url = $(this).data('search');
      let $keyword = $('#search Keyword').val();
      let $company = $('#CompanyId').val();
      let $min_price = $('#minPrice').val();
      let $max_price = $('#maxPrice').val();
      let $min_stock = $('#minStock').val();
      let $max_stock = $('#maxStock').val();
    
      $.ajax({
        type: 'GET', 
        url: 'search',
        data: { 
                _token: csrfToken,
                "keyword": $keyword,
                "company": $company,
                "min_price": $min_price,
                "max_price": $max_price,
                "min_stock": $min_stock,
                "max_stock": $max_stock, 
              },
        // dataType:'json',
  
      }).done(function(products){
          let table = $('.table tbody');
          table.empty();
          let html = '';
          
          for (let i = 0; i < products.data.length; i++) {
            let id = products.data[i].id;
            let img_path = products.data[i].img_path;
            let name = products.data[i].product_name;
            let price = products.data[i].price;
            let stock = products.data[i].stock;
            let company = products.data[i].company_name;
            let img_url = 'http://localhost:80/cytech/public/storage/' + img_path;
            html = `
            <tr class="table-row" data-id="{{ $product->id }}">
              <td class="table-data">${id}</td>
              <td class="table-data"><img width="100px" src="${img_url}"></td>
              <td class="table-data">${name}</td>
              <td class="table-data">${price}</td>
              <td class="table-data">${stock}</td>
              <td class="table-data">${company}</td>
              <td class="table-data"><a href="/cytech/public/detail/${id}" class="btn btn-primary btn-sm">詳細</a></td>
              <td class="table-data">
                <form method="POST" action="/cytech/public/delete/${id}" class="delete-form">
                    <button data-id="${id}" type="submit" data-url="/step8/public/delete/${id}" class="btn btn-danger btn-sm btn-delete">削除</button>
                </form>
              </td>
              <td class="table-data"><a href="/cytech/public/cart/" class="btn btn-warning btn-sm">購入</a></td>
            </tr>
          `;
            table.append(html);
            // テーブルソートを再適用
            $('.table').trigger('update');
            }
         }).fail(function(error){
            console.log("fail", error);
         })
    });
  });

  