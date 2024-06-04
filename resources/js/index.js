$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $("[name='csrf-token']").attr("content") },
})
$("#btn-search").on('submit', function(e){
    e.preventDefault(); //デフォルトイベント(フォームを送信するための通信)を止める
    var myForm = $("#my-form");
    var data = myForm.val();
    $.ajax({
        url: "{{ route('products.index') }}",
        method: "GET",
        date:"data",
        dataType: "json", //非同期でデータが渡せる
    }).done(function (data) {
        //jsonデータをビューに表示させる
        $("#table-list").append(data['list']);
    }).fail(function(){
        alert('error')
    })
});