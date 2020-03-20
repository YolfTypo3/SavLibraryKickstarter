.. include:: ../../Includes.txt

.. _generalAttributes:

==================
General Attributes
==================

======================================================= =========== ============ ==== ====
Property                                                Data type   Default      Plus Mvc
======================================================= =========== ============ ==== ====
:ref:`general.addEdit`                                  Boolean     0            Yes  No
:ref:`general.addEditIfAdmin`                           Boolean     0            Yes  No
:ref:`general.addEditIfNull`                            Boolean     0            Yes  No
:ref:`general.addLeftIfNotNull`                         String                   Yes  No
:ref:`general.addLeftIfNull`                            String                   Yes  No
:ref:`general.addNewIcon`                               Boolean     0            Yes  No
:ref:`general.addRighIfNotNull`                         String                   Yes  No
:ref:`general.addRighIfNull`                            String                   Yes  No
:ref:`general.alias`                                    Field name               Yes  No
:ref:`general.classLabel`                               String                   Yes  Yes
:ref:`general.classValue`                               String                   Yes  Yes
:ref:`general.cutIf`                                    String                   Yes  Yes
:ref:`general.cutIfNull`                                Boolean     0            Yes  Yes
:ref:`general.cutLabel`                                 Boolean     0            Yes  Yes
:ref:`general.edit`                                     Boolean     1            Yes  Yes
:ref:`general.editAdminPlus`                            Boolean     0            Yes  No
:ref:`general.func`                                     String                   Yes  No
:ref:`general.funcAddLeftIfNotNull`                     String                   Yes  No
:ref:`general.funcAddLeftIfNull`                        String                   Yes  No
:ref:`general.funcAddRightIfNotNull`                    String                   Yes  No
:ref:`general.funcAddRightIfNull`                       String                   Yes  No
:ref:`general.fusion`                                   {begin,                  Yes  Yes
                                                        end}
:ref:`general.label`                                    String                   Yes  Yes
:ref:`general.mail`                                     Boolean     0            Yes  No
:ref:`general.mailAlways`                               Boolean     0            Yes  No
:ref:`general.mailAuto`                                 Boolean     0            Yes  No
:ref:`general.onLabel`                                  Boolean     0            Yes  No
:ref:`general.orderLinkInTitle`                         Boolean     0            Yes  Yes
:ref:`general.orderLinkInTitleSetup`                    String      :link:       Yes  Yes
:ref:`general.query`                                    SQL                      Yes  No
                                                        statements
:ref:`general.queryOnValue`                             String                   Yes  No
:ref:`general.queryForEach`                             Field name               Yes  No
:ref:`general.renderReqValue`                           Boolean     0            Yes  No
:ref:`general.reqValue`                                 SQL SELECT               Yes  No
                                                        statement
:ref:`general.showIf`                                   String                   Yes  Yes
:ref:`general.setExtendLink`                            Table name               Yes  No
:ref:`general.stdWrapItem`                              stdWrap                  Yes  No
:ref:`general.stdWrapValue`                             stdWrap                  Yes  Yes
:ref:`general.styleLabel`                               String                   Yes  Yes
:ref:`general.styleValue`                               String                   Yes  Yes
:ref:`general.tsObject`                                 cObject                  Yes  No
:ref:`general.tsProperties`                             String                   Yes  Yes
:ref:`general.value`                                    String                   Yes  Yes
:ref:`general.verifier`                                 String                   Yes  No
:ref:`general.verifierMessage`                          String                   Yes  No
:ref:`general.verifierParam`                            String                   Yes  No
:ref:`general.verifierSetWarning`                       Boolean     0            Yes  No
:ref:`general.wrapInnerItem`                            Wrap                     Yes  No
:ref:`general.wrapItem`                                 Wrap                     Yes  Yes
:ref:`general.wrapItemIfNotCut`                         Wrap                     Yes  No
:ref:`general.wrapValue`                                Wrap                     Yes  No
======================================================= =========== ============ ==== ====



.. _general.addEdit:
  
addEdit
=======

.. container:: table-row

    Property
        addEdit

    Data type
        Boolean      
           
    Description
        When the field is used in an **Update form** view, it will add an input
        element for update that can be used with the marker
        **###field_name_Edit###** where **field_name** is the name of the field.
             
        See also the help for Form views (showAllItemTemplate) to see how to
        use markers **###field[field_name, label]###**. 
       
    Default
        0


.. _general.addEditIfAdmin:

addEditIfAdmin
==============

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
     
  
.. _general.addEditIfNull:

addEditIfNull
=============
   
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


.. _general.addLeftIfNotNull:

addLeftIfNotNull
================

.. container:: table-row

    Property
        addLeftIfNotNull 
       
    Data type
        String      
            
    Description
        String will be added to the left if the field value is not null.
       
    Default
        0 


.. _general.addLeftIfNull:

addLeftIfNull
=============

.. container:: table-row

    Property
        addLeftIfNull 
                  
    Data type
        String
       
    Description
        String will be added to the left if the field value is null.


.. _general.addNewIcon:

addNewIcon
==========

.. container:: table-row

    Property
       addNewIcon

    Data type
        Integer

    Description
        A new icon, will be displayed in front of the field during the number
        of days given by the int number.


.. _general.addRighIfNotNull:

addRighIfNotNull
================

.. container:: table-row

    Property
        addRighIfNotNull
         
    Data type
        String
  
    Description
        String will be added to the right if the field value is not null.
   

   

.. _general.addRighIfNull:

addRighIfNull
=============

.. container:: table-row

    Property
        addRighIfNull
         
    Data type
        String
  
    Description
        String will be added to the right if the field value is null.
   


.. _general.alias:

alias
=====

.. container:: table-row

    Property
        alias       

    Data type
        Field name
  
    Description
        The displayed value will be provided by the fieldname value for the
        current record.
    


.. _general.classLabel:

classLabel
==========

.. container:: table-row

    Property
        classLabel 
   
    Data type
        String
        
    Description
        The default class **label** associated with the label of the displayed
        value will be replaced by the string.



.. _general.classValue:

classValue
==========

.. container:: table-row

    Property
        classValue       

    Data type
        String
      
    Description
        The default class **value** associated with the displayed value will be
        replaced by the string.   
       



.. _general.cutIf:

cutIf (showIf, requiredIf, queryIf, reqValueIf, editIf, valueif)
================================================================

.. container:: table-row

    Property
        cutIf (showIf, mailIf, requiredIf, queryIf, reqValueIf, editIf, valueIf)
             
    Data type
      String
         
    Description
        If the condition is true, the property cut, show, mail, required, query, 
        reqValue, edit or value is activated. The string can be:
             
        - fieldName operator value. Operator can be =, !=, >, <, >= or <=. 
          The condition is true if current value of the field is
          equal to the given value. The markers **###user###** or **###cruser###** (same
          as user but should be used if a new record is created) will be
          replaced by the user id. 
          
        - fieldName operateur specialValue. Operator can be is or isnot. 
          The special value can be **EMPTY** or **NEW**. The condition is true is the field
          is (or is not) empty (or a new record).
          
        - ###filter = filterName_contentId### The field is cut if the filter with attribut name **filterName**
          and content id **contentId** is used, e.g. ###filter = searchValue_3490###. 
          
        - ###filter != filterName_contentId### The field is cut if the filter with attribut name **filterName**
          and content id **contentId** is used, e.g. ###filter != searchValue_3490###.           
             
        - ###usergroup =g roup_name### The field is cut or shown if the group
          **group_name** is a valid group for the current user.
             
        - ###usergroup != group_name### The field is cut or shown if the group
          **group_name** is not a valid group for the current user.
             
        - ###group = group_name### The field is cut or shown if the group
          **group_name** is a valid group for the current record. It checks the
          usergroup field in the local table if any.
             
        - ###group != group_name### The field is cut or shown if the group
          **group_name** is not a valid group for the current record. It checks
          the usergroup field in the local table if any.
             
        Logical connectors &, \|, and, or can be used between expression.
  
  
.. _general.cutIfNull:

cutIfNull
=========

.. container:: table-row

    Property
        cutIfNull    

    Data type
        Boolean
     
    Description
        Cut the field if it is empty.
      
    Default
        0


.. _general.cutLabel:

cutLabel
========

.. container:: table-row

    Property
        cutLabel

    Data type
        Boolean           

    Description
        Cuts the label associated with the field.
   
    Default
        0


.. _general.edit:

edit
====

.. container:: table-row

    Property
        edit  
       
    Data type
        Boolean
                     
    Description
        Makes the field not editable in an input form.
       
    Default
        1 in Edit views 


.. _general.editAdminPlus:

editAdminPlus
=============

.. container:: table-row

    Property
        editAdminPlus
         
    Data type
        Boolean 
       
    Description
        Makes the field editable in an input form, if the user has the
        **Admin+** right. To be an **Admin** user, his/her TSConfig must contain a
        line as follows:
             
        - extKey_Admin=value where **extKey** is the extension key and value is
          one of the possible value of the **Input Admin Field** defined in the
          flexform associated with the extension.
             
        - The user becomes an **Admin+** user, if his/her TSConfig contains a line
          as follows:
             
        ::
             
            extKey_Admin=value+
       
        Default
            0


.. _general.func:

func
====

.. container:: table-row

    Property
        func

    Data type
        String
                 
    Description
        See :ref:`functions`.
   


.. _general.funcAddLeftIfNotNull:

funcAddLeftIfNotNull
====================

.. container:: table-row

    Property
        funcAddLeftIfNotNull
   
    Data type
        String
               
    Description
        String will be added to the left if the result of the applied
        function, defined by **func=function_name;** property, is not null.


.. _general.funcAddLeftIfNull:

funcAddLeftIfNull
=================

.. container:: table-row

    Property
       funcAddLeftIfNull     
   
    Data type
        String
         
    Description
        String will be added to the left if the result of the applied
        function, defined by **func=function_name;** property, is null.



.. _general.funcAddRightIfNotNull:

funcAddRightIfNotNull
=====================

.. container:: table-row

    Property
       funcAddRightIfNotNull 

    Data type
        String
         
    Description
        String will be added to the right if the result of the applied
        function, defined by **func=function_name;** property, is not null.
   


.. _general.funcAddRightIfNull:

funcAddRightIfNull
==================
   
.. container:: table-row

    Property   
        funcAddRightIfNull

    Data type
        String   

    Description
        String will be added to the right if the result of the applied
        function, defined by **func=function_name;** property, is null.
   


.. _general.fusion:

fusion
======

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
   


.. _general.label:

label
=====

.. container:: table-row

    Property  
        label
        
    Data type
        String               

    Description
        The displayed label will be provided by the string.



.. _general.mail:

mail
====

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
         
        - fieldForCheckMail=field_name; The mail will be sent if the value of
          the fieldname for the current row is not null.
         
        - mailIfFieldSetTo=string; The mail will be sent if the value of the
          fieldname for the current row was previously null or zero and is set
          to the given string value. If the string is a comma- separated list of
          values, the mail is sent is the value of the fieldname for the current
          row belongs to this list (only in SAV Library Plus).
         
        - mailSender=string; mail of the sender. The marker **###user_email###** will
          be replaced by the user email.
         
        - mailReceiver=string; mail of the person who will receive the mail and
          process the information.
         
        - mailReceiverFromField=field_name; The **field_name** contains the mail
          of the person who will receive the mail and process the information.
         
        - mailReceiverFromQuery=MySQL_Query; The receiver is obtained from a
          select query with an alias **value** that will used to retrieve the
          receiver. Example:
         
          ::
         
            SELECT email AS value FROM fe_users WHERE ... 
         
        - mailSubject=string; subject of the mail. Markers **###fieldname###** are
          allowed and will be replaced by their current value.
         
        - mailMessage=string, mail message. Markers **###fieldname###** are allowed
          and will be replaced by their current value.
         
        - mailcc=string; if set the string is used as Cc: for the mail.

        - mailccFromField=field_name; The **field_name** contains the mail
          of the person who will receive the mail in carbon copy.
         
        - mailReceiverFromQuery=MySQL_Query; The receiver is obtained from a
          select query with an alias **value** that will used to retrieve the
          carbon copy information.
                   
        - mailMessageLanguage=string; This parameter will force the language for
          the message to the value of the string.
         
        - mailMessageLanguageFromField=fieldname; This parameter will force the
          language for the message to the value of the field (for example a
          selector box).
         
        Localization by means of the file **locallang.xlf** can be used with
        $$$tag$$$ which will be replaced by its value according to the
        configuration language.
   
    Default
        0


.. _general.mailAlways:

mailAlways
==========

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
         
        - mailSender=string; mail of the sender. The marker **###user_email###** will
          be replaced by the user email.
         
        - mailReceiver=string; mail of the person who will receive the mail and
          process the information.
         
        - mailReceiverFromField=field_name; The **field_name** contains the mail
          of the person who will receive the mail and process the information.
             
        - mailReceiverFromQuery=MySQL_Query; The receiver is obtained from a
          select query with an alias **value** that will used to retreive the
          receiver. Example:
         
          ::
         
            SELECT email AS value FROM fe_users WHERE ... 
         
        - mailSubject=string; subject of the mail. Markers ###fieldname### are
          allowed and will be replaced by their current value.
         
        - mailMessage=string, mail message. Markers ###fieldname### are allowed
          and will be replaced by their current value.
         
        - mailcc=string; if set the string is used as Cc: for the mail.

        - mailccFromField=field_name; The **field_name** contains the mail
          of the person who will receive the mail in carbon copy.
         
        - mailReceiverFromQuery=MySQL_Query; The receiver is obtained from a
          select query with an alias **value** that will used to retrieve the
          carbon copy information.
                   
        Localization by means of the file **locallang.xlf** can be used with
        $$$tag$$$ which will be replaced by its value according to the
        configuration language.
         
        - mailMessageLanguage=string; This parameter will force the language for
          the message to the value of the string.
         
        - mailMessageLanguageFromField=fieldname; This parameter will force the
          language for the message to the value of the field (for example a
          selector box).
    
    Default
        0


.. _general.mailAuto:

mailAuto
========

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
         
        - mailSender=string; mail of the sender. The marker **###user_email###**
          will be replaced by the user email.
         
        - mailReceiver=string; mail of the person who will receive the mail and
          process the information.
         
        - mailReceiverFromField=field_name; The **field_name** contains the mail
          of the person who will receive the mail and process the information.
         
        - mailReceiverFromQuery=MySQL_Query; The receiver is obtained from a
          select query with an alias **value*** that will used to retreive the
          receiver. Example:
         
        ::
         
            SELECT email AS value FROM fe_users WHERE ... 
         
        - mailSubject=string; subject of the mail. Markers **###fieldname###** are
          allowed and will be replaced by their current value.
         
        - mailMessage=string, mail message. Markers **###fieldname###** are allowed
          and will be replaced by their current value.
           
        - mailcc=string; if set the string is used as Cc: for the mail.

        - mailccFromField=field_name; The **field_name** contains the mail
          of the person who will receive the mail in carbon copy.
         
        - mailReceiverFromQuery=MySQL_Query; The receiver is obtained from a
          select query with an alias **value** that will used to retrieve the
          carbon copy information.        
         
        Localization by means of the file **locallang.xlf** can be used with
        $$$tag$$$ which will be replaced by its value according to the
        onfiguration language.
         
        - mailMessageLanguage=string; This parameter will force the language for
          the message to the value of the string.
         
        - mailMessageLanguageFromField=fieldname; This parameter will force the
          language for the message to the value of the field (for example a
          selector box).
   
    Default
        0


.. _general.onLabel:

onLabel
=======

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


.. _general.orderLinkInTitle:

orderLinkInTitle
================

.. container:: table-row
       
    Property
        orderLinkInTitle       

    Data type
        Boolean
        
    Description
        If this property is set, it makes it possible to generate a hyperlink
        in the title bar of the **List** view. The hyperlink is associated with
        the field if the marker **###fieldname###** is used in the **Title bar**
        section. Order clauses have to be defined in the **Where Tags** section
        of the **Query Form**.
         
        Use the two followings **Where Tags**:
         
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
         
        If the optional part **Default** is used, by default the whereTagName1
        is assumed when the extension is launched.
         
        The optional whereTagName2 can be used to set a toggle link with two
        different behaviours.
     
    Default
        0


.. _general.orderLinkInTitleSetup:

orderLinkInTitleSetup
=====================

.. container:: table-row
       
    Property
        orderLinkInTitleSetup

    Data type
        String
                 
    Description    
        This property controls the display of the link when **orderLinkInTitle**
        is set. The format is **param1:param2:param3** where **param1** to
        **param3** can take the following values:
         
        - value: the field value is displayed,
         
        - link: the field value is displayed with a link which toggles the sort,
         
        - asc: an icon is displayed with a link to make an ascending sort,
         
        - desc: an icon is displayed with a link to make a descending sort,
         
        - ascdesc: two icons are displayed with separate links to make an
          ascending or descending sort.
         
        - if there is no value, nothing is displayed.
      
    Default
        :link:


.. _general.query:

query
=====

.. container:: table-row
       
    Property
        query        

    Data type
        SQL statements
  
    Description
        The query will be executed once the input form data have been saved.
        Therefore, it can only be used with **Edit** or **Update** views.
         
        .. important::
            Because any query may be executed, for security reason, this
            property can only be used if an admin user has checked the field
            **Allow the use of the “query” property** in the advanced folder of the
            flexform.
         
        It may be useful, for example, to update a specific table when the
        current data are saved. Several queries can be used in the SQL
        statements. Each query must be separated using **\\;**.
         
        Special markers can be used in the statement:
         
        - ###uid### or ###uidMainTable### will be replaced by the current record uid.
         
        - ###CURRENT_PID### will be replaced by the current page uid.
         
        - ###user### will be replaced by the user id.
         
        - ###value### will be replaced by the current value for the field.
   



.. _general.queryOnValue:

queryOnValue
============

.. container:: table-row
       
    Property 
        queryOnValue

    Data type
        String              

    Description
        The query, as defined above, will be executed if the current field
        value is equal to the right hand side string.
   


.. _general.queryForEach:

queryForEach
============

.. container:: table-row
       
    Property 
        queryForEach
        
    Data type
        Field name 
                      
    Description
        If the field is a true MM relation, the query, as defined above, will
        be executed for all the record in the relation.
         
        The special marker **###field_name###**, where **field_name** is the field
        where the relation is defined, can be used to identify the record. It
        will be replaced by the uid of the associated record.
   

   



.. _general.renderReqValue:

renderReqValue
==============

.. container:: table-row
       
    Property 
        renderReqValue

    Data type
        Boolean               
    Description
        Rendering is applied to the value provided by the **reqValue** attribute
        according to the type of the field.
   
    Default
        0


.. _general.reqValue:

reqValue
========

.. container:: table-row
       
    Property  
        reqValue    

    Data type
        SQL SELECT statement       

    Description
        SQL SELECT statement must have an alias **value** which will be used as
        the value to display.
         
        Special markers can be used in the statement :
         
        - ###uid### will be replaced by the current record uid.
                 
        - ###uidMainTable### will be replaced by the uid of the reccord in the
          main table.
         
        - ###user### will be replaced by the user id.
         
        - ###row[field_name]### where **field_name** is the name of a field in the
          current record, will be replaced by its current value.
         
        The following example returns the name of the user who has created the
        current record, assuming that **tx_mytable** is the local table:
         
        ::
         
            reqValue= SELECT name AS value 
            FROM fe_users
            WHERE uid=(SELECT cruser_id FROM tx_mytable WHERE uid=###uid###);
   

   

  

.. _general.setExtendLink:

setExtendLink
=============

.. container:: table-row
       
    Property  
        setExtendLink
           
    Data type
        Table name 
            
    Description
        The table name will be left-joined to existing tables.

   



.. _general.showIf:

showIf
======

.. container:: table-row
       
    Property  
        showIf
        
    Data type
        String       

    Description
        See :ref:`general.cutIf`.         

   



.. _general.stdWrapItem: 

stdWrapItem
===========

.. container:: table-row

    Property 
        stdWrapItem
           
    Data type
        stdWrap  
         
    Description
        It defines a conventional TypoScript stdWrap property. You can add
        here full TypoScript syntax.
         
        .. important::
        
            Do not forget that the configuration field is ended by a semi-column,
            therefore if you need a semi-column in your TypoScript write it **\\;**.
          



.. _general.stdWrapValue:

stdWrapValue
============

.. container:: table-row

    Property 
        stdWrapValue       

    Data type
        stdWrap
  
    Description
        It defines a conventional TypoScript stdWrap property. You can add
        here full TypoScript syntax.
         
        .. important:: 
            Do not forget that the configuration field is ended by a semi-column,
            therefore if you need a semi-column in your TypoScript write it **\\;**.
   
  
  
.. _general.styleLabel:

styleLabel
==========

.. container:: table-row

    Property 
        styleLabel   

    Data type
        String
        
    Description
        The string will be added as a style attribute associated with the
        label of the displayed value.
   



.. _general.styleValue:

styleValue
==========

.. container:: table-row

    Property 
        styleValue
 
    Data type
        String   
         
    Description
        The string will be added as a style attribute associated with the
        displayed value.




.. _general.tsObject:

tsObject
========

.. container:: table-row
       
    Property  
        tsObject    

    Data type
        cObject
              
    Description
        It defines a TypoScript content object (e.g. TEXT)
   
   


.. _general.tsProperties:

tsProperties
============

.. container:: table-row

    Property 
        tsProperties
          
    Data type
        String
           
    Description
        It defines the properties of the TypoScript cObject.
         
        .. important::
            Do not forget that the configuration field is ended by a semi-column,
            therefore if you need a semi-column in your TypoScript write it **\\;**.




.. _general.value:

value
=====

.. container:: table-row

    Property 
        value

    Data type
        String       

    Description
        It defines directly the value for the field.
  
   


.. _general.verifier:

verifier
========

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
   


.. _general.verifierMessage:

verifierMessage
===============

.. container:: table-row

    Property 
        verifierMessage
        
    Data type
        String      
   
    Description
        It replaces the default message.
         
        Localization by means of the file **locallang.xlf** can be used with
        $$$tag$$$ which will be replaced by its value according to the
        configuration language.
         
        The marker **$$$label[fieldName]$$$** will be replaced by the fieldName
        title according to the localization.
   

.. _general.verifierParam:

verifierParam
=============

.. container:: table-row

    Property 
        verifierParam
           
    Data type
        String   
  
    Description
        The string can be:
         
        - a regular expression for the verifier **isValidPattern**. For example
          /=[A-Za-z0-9\_]*$/ will allow any input which contains letters,
          numbers or underline characters.
         
        - an integer value for the verifier **isValidLength**.
         
        - an interval [a, b] where a and b are integers for the verifier
          **isValidInterval**.
         
        - a SELECT query for **isValidQuery**. The marker **###value###** in the query
          will be replaced by the value of the field. The marker **###uid###** will
          be replaced by the uid of the current record.



.. _general.verifierSetWarning:

verifierSetWarning
==================

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

.. _general.wrapInnerItem:

wrapInnerItem
=============

.. container:: table-row

    Property  
        wrapItem    

    Data type
        Wrap 
         
    Description
        The string will be used to wrap the inner item. The syntax in the same as in
        TypoScript.
        
        Localization by means of the file locallang.xlf can be used with
        **$$$tag$$$** which will be replaced by its value according to the
        configuration language.
         
        The marker **$$$label[fieldName]$$$** will be replaced by the fieldName
        title according to the localization.
        
        
.. _general.wrapItem:

wrapItem
========

.. container:: table-row

    Property  
        wrapItem    

    Data type
        Wrap 
         
    Description
        The string will be used to wrap the item. The syntax in the same as in
        TypoScript.
         
        Localization by means of the file **locallang.xlf** can be used with
        **$$$tag$$$** which will be replaced by its value according to the
        configuration language.
         
        The marker **$$$label[fieldName]$$$** will be replaced by the fieldName
        title according to the localization.
        
.. _general.wrapItemIfNotCut:

wrapItemIfNotCut
================

.. container:: table-row

    Property  
        wrapItem    

    Data type
        Wrap 
         
    Description
        The string will be used to wrap the inner item if it is not cut. 
        The syntax in the same as in TypoScript.
        
        Localization by means of the file **locallang.xlf** can be used with
        **$$$tag$$$** which will be replaced by its value according to the
        configuration language.
         
        The marker **$$$label[fieldName]$$$** will be replaced by the fieldName
        title according to the localization. 
 
        
.. _general.wrapValue:

wrapInnerItem
=============

.. container:: table-row

    Property  
        wrapItem    

    Data type
        Wrap 
         
    Description
        The string will be used to wrap the value. The syntax in the same as in
        TypoScript.        
        
        Localization by means of the file **locallang.xlf** can be used with
        **$$$tag$$$** which will be replaced by its value according to the
        configuration language.
         
        The marker **$$$label[fieldName]$$$** will be replaced by the fieldName
        title according to the localization.        