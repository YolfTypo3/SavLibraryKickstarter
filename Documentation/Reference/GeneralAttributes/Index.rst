.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
  :class:  typoscript
.. role::   php(code)


General attributes
------------------

======================================================= =========== ============ ==== ====
Property                                                Data type   Default      Plus Mvc
======================================================= =========== ============ ==== ====
:ref:`General.addEdit`                                  Boolean     0            Yes  No
:ref:`General.addEditIfAdmin`                           Boolean     0            Yes  No
:ref:`General.addEditIfNull`                            Boolean     0            Yes  No
:ref:`General.addLeftIfNotNull`                         String                   Yes  No
:ref:`General.addLeftIfNull`                            String                   Yes  No
:ref:`General.addNewIcon`                               Boolean     0            Yes  No
:ref:`General.addRighIfNotNull`                         String                   Yes  No
:ref:`General.addRighIfNull`                            String                   Yes  No
:ref:`General.alias`                                    Field name               Yes  No
:ref:`General.classLabel`                               String                   Yes  Yes
:ref:`General.classValue`                               String                   Yes  Yes
:ref:`General.cutIf`                                    String                   Yes  Yes
:ref:`General.cutIfNull`                                Boolean     0            Yes  Yes
:ref:`General.cutLabel`                                 Boolean     0            Yes  Yes
:ref:`General.edit`                                     Boolean     1            Yes  Yes
:ref:`General.editAdminPlus`                            Boolean     0            Yes  No
:ref:`General.func`                                     String                   Yes  No
:ref:`General.funcAddLeftIfNotNull`                     String                   Yes  No
:ref:`General.funcAddLeftIfNull`                        String                   Yes  No
:ref:`General.funcAddRightIfNotNull`                    String                   Yes  No
:ref:`General.funcAddRightIfNull`                       String                   Yes  No
:ref:`General.fusion`                                   {begin,                  Yes  Yes
                                                        end}
:ref:`General.label`                                    String                   Yes  Yes
:ref:`General.mail`                                     Boolean     0            Yes  No
:ref:`General.mailAlways`                               Boolean     0            Yes  No
:ref:`General.mailAuto`                                 Boolean     0            Yes  No
:ref:`General.onLabel`                                  Boolean     0            Yes  No
:ref:`General.orderLinkInTitle`                         Boolean     0            Yes  Yes
:ref:`General.orderLinkInTitleSetup`                    String      \:link\:     Yes  Yes
:ref:`General.query`                                    SQL                      Yes  No
                                                        statements
:ref:`General.queryOnValue`                             String                   Yes  No
:ref:`General.queryForEach`                             Field name               Yes  No
:ref:`General.renderReqValue`                           Boolean     0            Yes  No
:ref:`General.reqValue`                                 SQL SELECT               Yes  No
                                                        statement
:ref:`General.showIf`                                   String                   Yes  Yes
:ref:`General.setExtendLink`                            Table name               Yes  No
:ref:`General.stdWrapItem`                              stdWrap                  Yes  No
:ref:`General.stdWrapValue`                             stdWrap                  Yes  No
:ref:`General.styleLabel`                               String                   Yes  Yes
:ref:`General.styleValue`                               String                   Yes  Yes
:ref:`General.tsObject`                                 cObject                  Yes  No
:ref:`General.tsProperties`                             String                   Yes  No
:ref:`General.value`                                    String                   Yes  Yes
:ref:`General.verifier`                                 String                   Yes  No
:ref:`General.verifierMessage`                          String                   Yes  No
:ref:`General.verifierParam`                            String                   Yes  No
:ref:`General.verifierSetWarning`                       Boolean     0            Yes  No
:ref:`General.wrapItem`                                 Wrap                     Yes  Yes
======================================================= =========== ============ ==== ====



.. _General.addEdit:
  
addEdit
^^^^^^^

.. container:: table-row

    Property
        addEdit

    Data type
        Boolean      
           
    Description
        When the field is used in an "Update form" view, it will add an input
        element for update that can be used with the marker
        ###field\_name\_Edit### where "field\_name" is the name of the field.
             
        See also the help for Form views (showAllItemTemplate) to see how to
        use markers ###field[field\_name, label]###. 
       
    Default
        0


.. _General.addEditIfAdmin:

addEditIfAdmin
^^^^^^^^^^^^^^

.. container:: table-row

    Property
        addEditIfAdmin
       
    Data type
        Boolean
           
    Description
        Same as addEdit but the element will be added only if the user has the
        input right for the plugin.
       
    Default
        0
     
  
.. _General.addEditIfNull:

addEditIfNull
^^^^^^^^^^^^^
   
.. container:: table-row

    Property
        addEditIfNull
           
    Data type
        Boolean
      
    Description
        Same as addEdit but the element will be added only if the field is
        null.   
       
    Default
        0


.. _General.addLeftIfNotNull:

addLeftIfNotNull
^^^^^^^^^^^^^^^^

.. container:: table-row

    Property
        addLeftIfNotNull 
       
    Data type
        String      
            
    Description
        String will be added to the left if the field value is not null.
       
    Default
        0 


.. _General.addLeftIfNull:

addLeftIfNull
^^^^^^^^^^^^^

.. container:: table-row

    Property
        addLeftIfNull 
                  
    Data type
        String
       
    Description
        String will be added to the left if the field value is null.


.. _General.addNewIcon:

addNewIcon
^^^^^^^^^^

.. container:: table-row

    Property
       addNewIcon

    Data type
        Boolean

    Description
        A new icon, will be displayed in front of the field during the number
        of days given by the int number.


.. _General.addRighIfNotNull:

addRighIfNotNull
^^^^^^^^^^^^^^^^

.. container:: table-row

    Property
        addRighIfNotNull
         
    Data type
        String
  
    Description
        String will be added to the right if the field value is not null.
   

   

.. _General.addRighIfNull:

addRighIfNull
^^^^^^^^^^^^^

.. container:: table-row

    Property
        addRighIfNull
         
    Data type
        String
  
    Description
        String will be added to the right if the field value is null.
   


.. _General.alias:

alias
^^^^^

.. container:: table-row

    Property
        alias       

    Data type
        Field name
  
    Description
        The displayed value will be provided by the fieldname value for the
        current record.
    


.. _General.classLabel:

classLabel
^^^^^^^^^^

.. container:: table-row

    Property
        classLabel 
   
    Data type
        String
        
    Description
        The default class "label" associated with the label of the displayed
        value will be replaced by the string.



.. _General.classValue:

classValue
^^^^^^^^^^

.. container:: table-row

    Property
        classValue       

    Data type
        String
      
    Description
        The default class "value" associated with the displayed value will be
        replaced by the string.   
       



.. _General.cutIf:

cutIf / showIf
^^^^^^^^^^^^^^

.. container:: table-row

    Property
        cutIf / showIf  
             
    Data type
      String
         
    Description
        The string can be:
             
        - fieldName=valueCuts / shows the field if current value of the field is
          equal to the given value. The markers ###user### or ###cruser### (same
          as user but should be used if a new record is created) will be
          replaced by the user id. Use EMPTY for the value to test an empty
          field.
             
        - fieldName!=valueCuts / shows the field if current value of the field
          is not equal to the given value. Same markers as above can be used.
             
        - ###usergroup=group\_name###The field is cut / shown if the group
          “group\_name” is a valid group for the current user.
             
        - ###usergroup!=group\_name###The field is cut / shown if the group
          “group\_name” is not a valid group for the current user.
             
        - ###group=group\_name###The field is cut / shown if the group
          “group\_name” is a valid group for the current record. It checks the
          usergroup field in the local table if any.
             
        - ###group!=group\_name###The field is cut / shown if the group
          “group\_name” is not a valid group for the current record. It checks
          the usergroup field in the local table if any.
             
        Logical connectors & and \| can be used between expression. However no
        parentheses are allowed.
  
  
.. _General.cutIfNull:

cutIfNull
^^^^^^^^^

.. container:: table-row

    Property
        cutIfNull    

    Data type
        Boolean
     
    Description
        Cut the field if it is empty.
      
    Default
        0


.. _General.cutLabel:

cutLabel
^^^^^^^^

.. container:: table-row

    Property
        cutLabel

    Data type
        Boolean           

    Description
        Cuts the label associated with the field.
   
    Default
        0


.. _General.edit:

edit
^^^^

.. container:: table-row

    Property
        edit  
       
    Data type
        Boolean
                     
    Description
        Makes the field not editable in an input form.
       
    Default
        1 in Edit views 


.. _General.editAdminPlus:

editAdminPlus
^^^^^^^^^^^^^

.. container:: table-row

    Property
        editAdminPlus
         
    Data type
        Boolean 
       
    Description
        Makes the field editable in an input form, if the user has the
        "Admin+" right. To be an "Admin" user, his/her TSConfig must contain a
        line as follows:
             
        - extKey\_Admin=value where “extKey” is the extension key and value is
          one of the possible value of the "Input Admin Field" defined in the
          flexform associated with the extension.
             
        - The user becomes an "Admin+" user, if his/her TSConfig contains a line
          as follows:
             
        ::
             
            extKey_Admin=value+
       
        Default
            0


.. _General.func:

func
^^^^

.. container:: table-row

    Property
        func

    Data type
        String
                 
    Description
        See :ref:`functions`.
   


.. _General.funcAddLeftIfNotNull:

funcAddLeftIfNotNull
^^^^^^^^^^^^^^^^^^^^

.. container:: table-row

    Property
        funcAddLeftIfNotNull
   
    Data type
        String
               
    Description
        String will be added to the left if the result of the applied
        function, defined by "func=function\_name;" property, is not null.


.. _General.funcAddLeftIfNull:

funcAddLeftIfNull
^^^^^^^^^^^^^^^^^

.. container:: table-row

    Property
       funcAddLeftIfNull     
   
    Data type
        String
         
    Description
        String will be added to the left if the result of the applied
        function, defined by "func=function\_name;" property, is null.



.. _General.funcAddRightIfNotNull:

funcAddRightIfNotNull
^^^^^^^^^^^^^^^^^^^^^

.. container:: table-row

    Property
       funcAddRightIfNotNull 

    Data type
        String
         
    Description
        String will be added to the right if the result of the applied
        function, defined by "func=function\_name;" property, is not null.
   


.. _General.funcAddRightIfNull:

funcAddRightIfNull
^^^^^^^^^^^^^^^^^^
   
.. container:: table-row

    Property   
        funcAddRightIfNull

    Data type
        String   

    Description
        String will be added to the right if the result of the applied
        function, defined by "func=function\_name;" property, is null.
   


.. _General.fusion:

fusion
^^^^^^

.. container:: table-row

    Property   
        fusion    

    Data type
        {begin, end}
         
    Description
        - fusion = begin;
         
        Starts the fusion of the fields, that is the following fields will be
        displayed on the same line.
         
        - fusion = end;
         
        Ends the fusion of the fields, that is the following field will be
        displayed on the next line.
   


.. _General.label:

label
^^^^^

.. container:: table-row

    Property  
        label
        
    Data type
        String               

    Description
        The displayed label will be provided by the string.



.. _General.mail:

mail
^^^^

.. container:: table-row

    Property  
        mail   
        
    Data type
        Boolean
              
    Description
        A mail will be associated with the field.
         
        If the field is a checkbox, it is used as a flag to verify is the mail
        has to be sent. Mail information are the following and can be used as
        properties:
         
        - fieldForCheckMail=field\_name; The mail will be sent if the value of
          the fieldname for the current row is not null.
         
        - mailIfFieldSetTo=string; The mail will be sent if the value of the
          fieldname for the current row was previously null or zero and is set
          to the given string value. If the string is a comma- separated list of
          values, the mail is sent is the value of the fieldname for the current
          row belongs to this list (only in SAV Library Plus).
         
        - mailSender=string; mail of the sender. Marker ###user\_email### will
          be replaced by the user email.
         
        - mailReceiver=string; mail of the person who will receive the mail and
          process the information.
         
        - mailReceiverFromField=field\_name; The field\_name contains the mail
          of the person who will receive the mail and process the information.
         
        - mailReceiverFromQuery=MySQL\_Query; The receiver is obtained from a
          select query with an alias "value" that will used to retrieve the
          receiver. Example:
         
          ::
         
            SELECT email AS value FROM fe_users WHERE ... 
         
        - mailSubject=string; subject of the mail. Markers ###fieldname### are
          allowed and will be replaced by their current value.
         
        - mailMessage=string, mail message. Markers ###fieldname### are allowed
          and will be replaced by their current value.
         
        - mailcc=string; if set the string is used as Cc: for the mail.

        - mailccFromField=field\_name; The field\_name contains the mail
          of the person who will receive the mail in carbon copy.
         
        - mailReceiverFromQuery=MySQL\_Query; The receiver is obtained from a
          select query with an alias "value" that will used to retrieve the
          carbon copy information.
                   
        - mailMessageLanguage=string; This parameter will force the language for
          the message to the value of the string.
         
        - mailMessageLanguageFromField=fieldname; This parameter will force the
          language for the message to the value of the field (for example a
          selector box).
         
        Localization by means of the file locallang.xml can be used with
        $$$tag$$$ which will be replaced by its value according to the
        configuration language.
   
    Default
        0


.. _General.mailAlways:

mailAlways
^^^^^^^^^^

.. container:: table-row

    Property  
        mailAlways
    
    Data type
        Boolean
           
    Description
        **The mail property must be set (mail = 1;) when using this
        property.**
         
        The mail is always sent when saving. Mail information are the
        following:
         
        - mailSender=string; mail of the sender. Marker ###user\_email### will
          be replaced by the user email.
         
        - mailReceiver=string; mail of the person who will receive the mail and
          process the information.
         
        - mailReceiverFromField=field\_name; The field\_name contains the mail
          of the person who will receive the mail and process the information.
             
        - mailReceiverFromQuery=MySQL\_Query; The receiver is obtained from a
          select query with an alias "value" that will used to retreive the
          receiver. Example:
         
          ::
         
            SELECT email AS value FROM fe_users WHERE ... 
         
        - mailSubject=string; subject of the mail. Markers ###fieldname### are
          allowed and will be replaced by their current value.
         
        - mailMessage=string, mail message. Markers ###fieldname### are allowed
          and will be replaced by their current value.
         
        - mailcc=string; if set the string is used as Cc: for the mail.

        - mailccFromField=field\_name; The field\_name contains the mail
          of the person who will receive the mail in carbon copy.
         
        - mailReceiverFromQuery=MySQL\_Query; The receiver is obtained from a
          select query with an alias "value" that will used to retrieve the
          carbon copy information.
                   
        Localization by means of the file locallang.xml can be used with
        $$$tag$$$ which will be replaced by its value according to the
        configuration language.
         
        - mailMessageLanguage=string; This parameter will force the language for
          the message to the value of the string.
         
        - mailMessageLanguageFromField=fieldname; This parameter will force the
          language for the message to the value of the field (for example a
          selector box).
    
    Default
        0


.. _General.mailAuto:

mailAuto
^^^^^^^^

.. container:: table-row
       
    Property
        mailAuto       

    Data type
        Boolean
            
    Description
        **The mail property must be set (mail = 1;) when using this
        property.**
         
        The mail is sent when saving, if the field is not empty and if one
        field in the form is changed. Mail information are the following:
         
        - mailSender=string; mail of the sender. The marker ###user\_email###
          will be replaced by the user email.
         
        - mailReceiver=string; mail of the person who will receive the mail and
          process the information.
         
        - mailReceiverFromField=field\_name; The field\_name contains the mail
          of the person who will receive the mail and process the information.
         
        - mailReceiverFromQuery=MySQL\_Query; The receiver is obtained from a
          select query with an alias "value" that will used to retreive the
          receiver. Example:
         
        ::
         
            SELECT email AS value FROM fe_users WHERE ... 
         
        - mailSubject=string; subject of the mail. Markers ###fieldname### are
          allowed and will be replaced by their current value.
         
        - mailMessage=string, mail message. Markers ###fieldname### are allowed
          and will be replaced by their current value.
           
        - mailcc=string; if set the string is used as Cc: for the mail.

        - mailccFromField=field\_name; The field\_name contains the mail
          of the person who will receive the mail in carbon copy.
         
        - mailReceiverFromQuery=MySQL\_Query; The receiver is obtained from a
          select query with an alias "value" that will used to retrieve the
          carbon copy information.        
         
        Localization by means of the file locallang.xml can be used with
        $$$tag$$$ which will be replaced by its value according to the
        onfiguration language.
         
        - mailMessageLanguage=string; This parameter will force the language for
          the message to the value of the string.
         
        - mailMessageLanguageFromField=fieldname; This parameter will force the
          language for the message to the value of the field (for example a
          selector box).
   
    Default
        0


.. _General.onLabel:

onLabel
^^^^^^^

.. container:: table-row
       
    Property
        onLabel       

    Data type
        Boolean
        
    Description
        The value will be displayed in place of the label. Not so useful since
        the label can be cut.
     
    Default
        0


.. _General.orderLinkInTitle:

orderLinkInTitle
^^^^^^^^^^^^^^^^

.. container:: table-row
       
    Property
        orderLinkInTitle       

    Data type
        Boolean
        
    Description
        If this property is set, it makes it possible to generate a hyperlink
        in the title bar of the "list view". The hyperlink is associated with
        the field if the marker ###fieldname### is used in the "Title bar"
        section. Order clauses have to be defined in the "Where Tags" section
        of the "Query Form".
         
        Use the two followings “Where Tags”:
         
        ::
         
            Name: fieldname+
            WHERE Clause:
            ORDER BY Clause: tablename.fieldname
            Name: fieldname-
            WHERE Clause:
            ORDER BY Clause: tablename.fieldname DESC
         
        Note: orderLink can be also directly added in the title bar without
        any reference to a field. The syntax is:
         
        ::
         
            ###link(Default)[whereTagName1(,whereTageName2)]###
         
        If the optional part “Default” is used, by default the whereTagName1
        is assumed when the extension is launched.
         
        The optional whereTagName2 can be used to set a toggle link with two
        different behaviours.
     
    Default
        0


.. _General.orderLinkInTitleSetup:

orderLinkInTitleSetup
^^^^^^^^^^^^^^^^^^^^^

.. container:: table-row
       
    Property
        orderLinkInTitleSetup

    Data type
        String
                 
    Description    
        This property controls the display of the link when “orderLinkInTitle”
        is set. The format is “param1:param2:param3” where “param1” to
        “param3” can take the following values:
         
        - value: the field value is displayed,
         
        - link: the field value is displayed with a link which toggles the sort,
         
        - asc: an icon is displayed with a link to make an ascending sort,
         
        - desc: an icon is displayed with a link to make a descending sort,
         
        - ascdesc: two icons are displayed with separate links to make an
          ascending or descending sort.
         
        - if there is no value, nothing is displayed.
      
    Default
        \:link\:


.. _General.query:

query
^^^^^

.. container:: table-row
       
    Property
        query        

    Data type
        SQL statements
  
    Description
        The query will be executed once the input form data have been saved.
        Therefore, it can only be used with "input" or "update" views.
         
        .. important::
            Because any query may be executed, for security reason, this
            property can only be used if an admin user has checked the field
            “Allow the use of the “query” property” in the advanced folder of the
            flexform.
         
        It may be useful, for example, to update a specific table when the
        current data are saved. Several queries can be used in the SQL
        statements. Each query must be separated using "\;".
         
        Special markers can be used in the statement:
         
        - ###uid### will be replaced by the current record uid.
         
        - ###CURRENT\_PID### will be replaced by the current page uid.
         
        - ###STORAGE\_PID### will be replaced by the storage page uid.
         
        - ###user### will be replaced by the user id.
         
        - ###value### will be replaced by the current value for the field.
   



.. _General.queryOnValue:

queryOnValue
^^^^^^^^^^^^

.. container:: table-row
       
    Property 
        queryOnValue

    Data type
        String              

    Description
        The query, as defined above, will be executed if the current field
        value is equal to the right hand side string.
   


.. _General.queryForEach:

queryForEach
^^^^^^^^^^^^

.. container:: table-row
       
    Property 
        queryForEach
        
    Data type
        Field name 
                      
    Description
        If the field is a true MM relation, the query, as defined above, will
        be executed for all the record in the relation.
         
        The special marker ###field\_name###, where "field\_name" is the field
        where the relation is defined, can be used to identify the record. It
        will be replaced by the uid of the associated record.
   

   



.. _General.renderReqValue:

renderReqValue
^^^^^^^^^^^^^^

.. container:: table-row
       
    Property 
        renderReqValue

    Data type
        Boolean               
    Description
        Rendering is applied to the value provided by the "reqValue" attribute
        according to the type of the field.
   
    Default
        0


.. _General.reqValue:

reqValue
^^^^^^^^

.. container:: table-row
       
    Property  
        reqValue    

    Data type
        SQL SELECT statement       

    Description
        SQL SELECT statement must have an alias "value" which will be used as
        the value to display.
         
        Special markers can be used in the statement :
         
        - ###uid### will be replaced by the current record uid.
                 
        - ###uidMainTable### will be replaced by the uid of the reccord in the
          main table.
         
        - ###user### will be replaced by the user id.
         
        - ###row[field\_name]### where field\_name is the name of a field in the
          current record, will be replaced by its current value.
         
        The following example returns the name of the user who has created the
        current record, assuming that tx\_mytable is the local table:
         
        ::
         
            reqValue= SELECT name AS value 
            FROM fe_users
            WHERE uid=(SELECT cruser_id FROM tx_mytable WHERE uid=###uid###);
   

   

  

.. _General.setExtendLink:

setExtendLink
^^^^^^^^^^^^^

.. container:: table-row
       
    Property  
        setExtendLink
           
    Data type
        Table name 
            
    Description
        The table name will be left-joined to existing tables.

   



.. _General.showIf:

showIf
^^^^^^

.. container:: table-row
       
    Property  
        showIf
        
    Data type
        String       

    Description
        See :ref:`General.cutIf`.         

   



.. _General.stdWrapItem: 

stdWrapItem
^^^^^^^^^^^

.. container:: table-row

    Property 
        stdWrapItem
           
    Data type
        stdWrap  
         
    Description
        It defines a conventional TypoScript stdWrap property. You can add
        here full TS syntax.
         
        .. important::
        
            Do not forget that the configuration field is ended by a semi-column,
            therefore if you need a semi-column in your TS write it "\;".
          



.. _General.stdWrapValue:

stdWrapValue
^^^^^^^^^^^^

.. container:: table-row

    Property 
        stdWrapValue       

    Data type
        stdWrap
  
    Description
        It defines a conventional TypoScript stdWrap property. You can add
        here full TS syntax.
         
        .. important:: 
            Do not forget that the configuration field is ended by a semi-column,
            therefore if you need a semi-column in your TS write it "\;".
   
  
  
.. _General.styleLabel:

styleLabel
^^^^^^^^^^

.. container:: table-row

    Property 
        styleLabel   

    Data type
        String
        
    Description
        The string will be added as a style attribute associated with the
        label of the displayed value.
   



.. _General.styleValue:

styleValue
^^^^^^^^^^

.. container:: table-row

    Property 
        styleValue
 
    Data type
        String   
         
    Description
        The string will be added as a style attribute associated with the
        displayed value.




.. _General.tsObject:

tsObject
^^^^^^^^

.. container:: table-row
       
    Property  
        tsObject    

    Data type
        cObject
              
    Description
        It defines a TS content object (e.g. TEXT)
   
   


.. _General.tsProperties:

tsProperties
^^^^^^^^^^^^

.. container:: table-row

    Property 
        tsProperties
          
    Data type
        String
           
    Description
        It defines the properties of the TS cObject.
         
        .. important::
            Do not forget that the configuration field is ended by a semi-column,
            therefore if you need a semi-column in your TS write it “\;”.




.. _General.value:

value
^^^^^

.. container:: table-row

    Property 
        value

    Data type
        String       

    Description
        It defines directly the value for the field.
  
   


.. _General.verifier:

verifier
^^^^^^^^

.. container:: table-row

    Property 
        verifier   
         
    Data type
        String
       
    Description
        Verifiers can be used to check if a field satisfy a constraint. Each
        field can have one verifier. Each verifier is associated with a
        parameter.
                 
        The verifier name can be:
         
        - isValidPattern
         
        - isValidLength
         
        - isValidInterval
         
        - isValidQuery
   


.. _General.verifierMessage:

verifierMessage
^^^^^^^^^^^^^^^

.. container:: table-row

    Property 
        verifierMessage
        
    Data type
        String      
   
    Description
        It replaces the default message.
         
        Localization by means of the file locallang.xml can be used with
        $$$tag$$$ which will be replaced by its value according to the
        configuration language.
         
        The marker $$$label[fieldName]$$$ will be replaced by the fieldName
        title according to the localization.
   

.. _General.verifierParam:

verifierParam
^^^^^^^^^^^^^

.. container:: table-row

    Property 
        verifierParam
           
    Data type
        String   
  
    Description
        The string can be:
         
        - a regular expression for the verifier "isValidPattern". For example
          /^[A-Za-z0-9\_]\*$/ will allow any input which contains letters,
          numbers or underline characters.
         
        - an integer value for the verifier "isValidLength".
         
        - an interval [a, b] where a and b are integers for the verifier
          "isValidInterval".
         
        - a SELECT query for "isValidQuery". The marker ###value### in the query
          will be replaced by the value of the field. The marker ###uid### will
          be replaced by the uid of the current record.



.. _General.verifierSetWarning:

verifierSetWarning
^^^^^^^^^^^^^^^^^^

.. container:: table-row

    Property  
        verifierSetWarning    
   
    Data type
        Boolean
       
    Description
        If set an error detected by the verifier becomes a warning. In that
        case, the field content is written in the database (which is not the
        case for errors) and a message is displayed.
   
    Default
        0


.. _General.wrapItem:

wrapItem
^^^^^^^^

.. container:: table-row

    Property  
        wrapItem    

    Data type
        Wrap 
         
    Description
        The string will be used to wrap the item. The syntax in the same as in
        TypoScript.
         
        Localization by means of the file locallang.xml can be used with
        $$$tag$$$ which will be replaced by its value according to the
        configuration language.
         
        The marker $$$label[fieldName]$$$ will be replaced by the fieldName
        title according to the localization.




