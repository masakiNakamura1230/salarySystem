// 入力フォームデザイン-------------------
// ユーザーID
$(document).ready(function(){

  if($('.playTextboxUserId').val().length === 0){
    $('.playTextboxUserId').removeClass("focus");
  } else { 
    $('.playLabelUserId').addClass("focus")
  }

  $('.playTextboxUserId').blur(function() {
  if($(this).val().length === 0){
  $('.playLabelUserId').removeClass("focus");
  }
  else { return; }
  })
  .focus(function() {
    $('.playLabelUserId').addClass("focus")
  });
});

// パスワード
$(document).ready(function(){

  if($('.playTextboxPassword').val().length === 0){
    $('.playTextboxPassword').removeClass("focus");
  } else { 
    $('.playLabelPassword').addClass("focus")
  }

  $('.playTextboxPassword').blur(function() {
  if($(this).val().length === 0){
  $('.playLabelPassword').removeClass("focus");
  }
  else { return; }
  })
  .focus(function() {
    $('.playLabelPassword').addClass("focus")
  });
});

// パスワード再入力
$(document).ready(function(){

  if($('.playTextboxPasswordRe').val().length === 0){
    $('.playTextboxPasswordRe').removeClass("focus");
  } else { 
    $('.playLabelPasswordRe').addClass("focus")
  }

  $('.playTextboxPasswordRe').blur(function() {
  if($(this).val().length === 0){
  $('.playLabelPasswordRe').removeClass("focus");
  }
  else { return; }
  })
  .focus(function() {
    $('.playLabelPasswordRe').addClass("focus")
  });
});

// 氏名
$(document).ready(function(){

  if($('.playTextboxUserName').val().length === 0){
    $('.playTextboxUserName').removeClass("focus");
  } else { 
    $('.playLabelUserName').addClass("focus")
  }

  $('.playTextboxUserName').blur(function() {
  if($(this).val().length === 0){
  $('.playLabelUserName').removeClass("focus");
  }
  else { return; }
  })
  .focus(function() {
    $('.playLabelUserName').addClass("focus")
  });
});

// 秘密の質問
$(document).ready(function(){

  if($('.playTextboxQuestion').val().length === 0){
    $('.playLabelQuestion').removeClass("focus");
  } else { 
    $('.playLabelQuestion').addClass("focus")
  }

  $('.playTextboxQuestion').blur(function() {
    if($(this).val().length === 0){
      $('.playLabelQuestion').removeClass("focus");
    } else { return; }
  })
  .focus(function() {
    $('.playLabelQuestion').addClass("focus")
  });
});

// 仕事内容
$(document).ready(function(){

  if($('.playTextboxWork').val().length === 0){
    $('.playLabelWork').removeClass("focus");
  } else { 
    $('.playLabelWork').addClass("focus")
  }

  $('.playTextboxWork').blur(function() {
    if($(this).val().length === 0){
      $('.playLabelWork').removeClass("focus");
    } else { return; }
  })
  .focus(function() {
    $('.playLabelWork').addClass("focus")
  });
});

// 給与
$(document).ready(function(){

  if($('.playTextboxSalary').val().length === 0){
    $('.playLabelSalary').removeClass("focus");
  } else { 
    $('.playLabelSalary').addClass("focus")
  }

  $('.playTextboxSalary').blur(function() {
    if($(this).val().length === 0){
      $('.playLabelSalary').removeClass("focus");
    } else { return; }
  })
  .focus(function() {
    $('.playLabelSalary').addClass("focus")
  });
});


// 給与一覧画面---------------------------------------
// メッセージ投稿文字制限（50文字以上の場合アラート表示）
// $(function(){
//   $("#messageSend").on("click", function(){
//     if($("#messageBody").val().length > 50){
//       alert('メッセージは50文字以内で入力してください。')
//       return false;
//     }
//   })
// })
