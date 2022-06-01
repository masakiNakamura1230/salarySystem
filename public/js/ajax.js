$(function(){

  
  // レコードを全件表示---------------------------------
  $.ajax({

      
      type: "POST",
      url: "messageSelect.php",
      datatype: "json",
      data: {

        // タレントのID
        "messageShowTalentId" : $('#messageShowTalentId').val(),
        // 選択されている月
        "messageShowSelectMonth" : $('#messageShowSelectMonth').val()
      },

      // 通信が成功した時
      success: function(data) {

        // 取得したレコードをeachで順次取り出す
        $.each(data, function(key, value){

          // ログインしているユーザーは削除ボタン表示
          if($('#messageShowUserName').val() == value.name){

            // #messageDisplay内にappendで追記していく
            $('#messageDisplay').append(
              "<div class='messageInfo'><div class='messageInfoName leftItem'>" + value.name +"</div><div class='messageInfoColon'>：</div><div class='messageInfoBody leftItem'>" + value.body +"</div><div class='messageInfoDelete'><form action='messageDelete.php' method='post'><input type='hidden' class='deleteAjaxId' name='deleteId' value='" + value.id + "'><input type='submit' class='deleteAjaxBtn' value='削除' onclick='return confirm(\"メッセージを削除してもよろしいですかよろしいですか？\")'></form></div></div>");
          } else {
            $('#messageDisplay').append(
              "<div class='messageInfo'><div class='messageInfoName leftItem'>" + value.name +"</div><div class='messageInfoColon'>：</div><div class='messageInfoBody leftItem'>" + value.body +"</div><div class='messageInfoDelete'></div></div>");
          }
        });
      },

      // 通信が失敗した時
      error: function(){
        console.log("通信失敗");
        console.log(data);
      }
  });

  // 投稿(#messageSend)がクリックされた時の処理---------------
  $('#messageSend').on('click',function(){

    // メッセージ内容50文字以上の場合アラート表示
    if($("#messageBody").val().length > 50){
      alert('メッセージは50文字以内で入力してください。')
      return false;
    }
    
    $.ajax({
        type: "POST",
        url: "messageRegist.php",
        datatype: "json",
        data: {

          // タレントのID
          "messageTalentId" : $('#messageTalentId').val(),
          // 投稿したユーザー名
          "messageUserName" : $('#messageUserName').val(),
          // 投稿したメッセージ内容
          "messageBody" : $('#messageBody').val()
        },
        // 通信が成功した時
        success: function(data) {

          // 一覧に追加したレコード追記
          $.each(data, function(key, value){
            $('#messageDisplay').append("<div class='messageInfo'><div class='messageInfoName leftItem'>" + value.name +"</div><div class='messageInfoColon'>：</div><div class='messageInfoBody leftItem'>" + value.body +"</div><div class='messageInfoDelete'><form action='messageDelete.php' method='post'><input type='hidden' class='deleteAjaxId' name='deleteId' value='" + value.id + "'><input type='submit' class='deleteAjaxBtn' value='削除' onclick='return confirm(\"メッセージを削除してもよろしいですかよろしいですか？\")'></form></div></div>");
          });

          $("#messageBody").val() = '';
        },

        // 通信が失敗した時
        error: function(data) {
          console.log("通信失敗");
          console.log(data);
        }
      });
    return false;
  });
});
