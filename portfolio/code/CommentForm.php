<?php
class CommentForm extends Form {
 
     public function __construct($controller, $name) {
        // Create fields
        $fields = new FieldList(
            new TextField('Name'),
            new EmailField('Email'),
            new TextField('URL'),
            new TextareaField('Comment')
        );
        
        $actions = new FieldList(
            new FormAction('submit', 'Send')
        );

        $validator = new RequiredFields('Name', 'Email', 'Comment');
        
        parent::__construct($controller, $name, $fields, $actions, $validator);
     }
 
     public function forTemplate() {
            return $this->renderWith(array(
                 $this->class,
                 'Form'
            ));
     }
 
     public function submit($data, $form) {  
        $robot = 0;
         //indentify robots with the honeypot method
        if($this->request->postVar('Message')){
            $robot = 1;
            return; //abort if a robot filled the invisible message form field
        }
        $comment = new Comment();
        $comment->BlogEntryID = $this->controller->ID;
        $form->saveInto($comment);
        $comment->write();     

        $bodyText = '<b>New Comment from:</b> '. $data['Name'].'<br/>'
                .'<b>E-Mail:</b> '.$data['Email'].'<br/>'
                .'<b>URL:</b> '.$data['URL'].'<br/>'
                .'<b>Comment:</b> '.$data['Comment'].'<br/>';

        $this->controller->sendCMSMail($this->config()->to, $this->config()->from, $this->config()->from_name, $this->config()->subject, $bodyText);
        $this->controller->setCustomMessage('good', 'Thank you! Your comment was sent and waits for confirmation');
        $this->controller->redirectBack();
    }
}