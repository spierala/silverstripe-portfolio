$("#CommentForm_CommentForm").validate({
    rules: {
        Name : { required : true, minlength: 2 },
        Comment : { required : true, minlength: 2 },
        Email: {
            required: true,
            email: true
        }
    },
    messages:{
        'Comment' :  "Bitte hinterlassen Sie eine Nachricht."
    }
});

