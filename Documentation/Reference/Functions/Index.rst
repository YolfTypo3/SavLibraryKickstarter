.. include:: ../../Includes.txt

.. _functions:

=========
Functions
=========

Functions are applied to the value of the field. They can be also
applied to left and right contents. In this case, "Left" or "Right"
should be added to the function name and the optional attributes (**Not yet implemented in SAV Library Mvc**).

======================================================= =========== ============ ==== ====
Property                                                Data type   Default      Plus Mvc
======================================================= =========== ============ ==== ====
:ref:`functions.makeDateFormat`                         None                     Yes  Yes
:ref:`functions.makeEmailLink`                          None                     Yes  Yes
:ref:`functions.makeExtLink`                            None                     Yes  No
:ref:`functions.makeImage`                              None                     Yes  No
:ref:`functions.makeItemLink`                           None                     Yes  Yes
:ref:`functions.makeLink`                               None                     Yes  No
:ref:`functions.makeNewWindowLink`                      None                     Yes  No
:ref:`functions.makeUrlLink`                            None                     Yes  No
:ref:`functions.makeXmlLabel`                           None                     Yes  No
======================================================= =========== ============ ==== ====


.. _functions.makeDateFormat:

func = makeDateFormat;
======================

.. container:: table-row

    Property 
        func = makeDateFormat;    

    Data type
        None   
         
    Description
        This function generates a format for a unix timestamp date.
         
        Optional attributes can be added:
         
        - format = string; The string should be a format that makes sense for
          the php-function strftime(). By defaut, "%d/%m/%Y" and "%d/%m/%Y %H:%M" are 
          respectively used for date and datetime.



..  _functions.makeEmailLink:

func = makeEmailLink;
=====================

.. container:: table-row

    Property 
        func = makeEmailLink;    

    Data type
        None  
       
    Description
        This function generates an email link associated with the field.
         
        Optional attributes can be added:
         
        - message = string; Message associated with the link.
         
        - fieldMessage = fieldName; Sets the attribute "message" with the
          content of the field whose name is given by fieldName.



.. _functions.makeExtLink:

func = makeExtLink;
===================

.. container:: table-row

    Property 
        func = makeExtLink;

    Data type
        None 
                            
    Description
        This function generates a hyperlink associated with the value of the
        field. It will open the "showSingle" view associated with the selected
        item in another extension. The following attributes must be provided:
         
        - ext = string; (string is the extension name followedby the form name.
          Example "myext\_intranet").
         
        - pageId = integer; (integer is the page id where the extension is the
          content element).
         
        - contentId = integer; (integer is the content id of the extension).
         
        Optional attributes can be added:
         
        - folderTab = string; (string is the folder tab name, if the extension
          uses serveral folders).         
                  
        - setUid = integer; the integer defines the page uid associated with the
          link.
         
        - valueIsUid = 1; The field value is used as the uid of the page
          associated with the link.
         
        - restrictLinkTo = ###usergroup=group\_name###; the link will be
          displayed if the user belongs to the group\_name.
         
        - restrictLinkTo = ###usergroup!=group\_name###; the link will be
          displayed if the user does not belong to the group\_name.
   


.. _functions.makeImage:

func = makeImage;
=================

.. container:: table-row

    Property 
        func = makeImage;    

    Data type
        None        
        
    Description
        This function builds an IMG tag where the field value is the name of
        the image file.
         
        Additional parameter can be used.
         
        - folder = string; (string will be the folder where the file should be).
         
        - width = integer; (width of the image in pixels).
         
        - height = integer; (height of the image in pixels).
         
        - alt = string; (string will be the "alt" attribute of the image).
         
        - fieldAlt = field\_name; (the "alt" attribute will be the value of the
          fieldname for the current record).
   


.. _functions.makeItemLink:

func = makeItemLink;
====================

.. container:: table-row

    Property 
        func = makeItemLink;

    Data type
        None  
              
    Description
        This function generates a hyperlink associated with the value of the
        field. It will open the "Single" view associated with the selected
        item.
         
        Optional attributes can be added:
         
        - folderTab = string; (string is the folder tab name, if the extension
          uses serveral folders).
         
        - updateForm = 1; makes it possible to open an "update" view instead of
          the "Show single" view (**Not yet implemented in SAV Library Mvc**).
         
        - inputForm = 1; makes it possible to open an "Edit" view instead
          of the "Single" view.
         
        - setUid = integer; the integer defines the page uid associated with the
          link.
         
        - valueIsUid = 1; The field value is used as the uid of the page
          associated with the link (**Not yet implemented in SAV Library Mvc**).



.. _functions.makeLink:

func = makeLink;
================

.. container:: table-row

    Property 
        func = makeLink;
        
    Data type
        None  
               
    Description
        This function generates an internal link (typolink).
                               
        Optional attributes can be added:
         
        - folder = string; The string will be the 
          folder where the file should be.
         
        - target = string; The string defines the 
          target parameter.
         
        - class = string; Name of the class associated 
          with the link.
         
        - message = string; Message associated with 
          the link.
         
        - fieldMessage = fieldName; Sets the attribute
          "message" with the content of the field whose
          name is given by fieldName.
         
        - setUid = integer; the integer defines the 
          page uid associated with the link.
         
        - valueIsUid = 1; The field value is used as 
          the uid of the page associated with the link.


.. _functions.makeNewWindowLink:

func = makeNewWindowLink;
=========================

.. container:: table-row

    Property 
        func = makeNewWindowLink;    
        
    Data type
        None             

    Description
        This function generates a hyperlink associated with the value of the
        field which opens a new window. Paramaters are :
         
        - windowUrl = string; string is the url. The marker
          ###special[fieldname]### from selectors can be used. This parameter is
          not necessary if the field is an image.
         
        Optional attributes can be added:
         
        - windowText = string; string will be added above the image. The marker
          ###special[fieldname]### from selectors can be used.
         
        - windowBodyStyle = string; string will be added as the style attribute
          to the body html tag. Do not forget to use \; for style attributes,
          since the semi-colon is use to split field attributes, and do not
          forget to end your definition by a semi-colon. Example:
         
        ::
         
            windowBodyStyle = fontweight:bold\;font-color:blue\;;
         
        - message = string; Message associated with the link.
         
        - fieldMessage = fieldName; Sets the attribute "message" with the
          content of the field whose name is given by fieldName.
     


.. _functions.makeUrlLink:

func = makeUrlLink;
===================

.. container:: table-row

    Property 
        func = makeUrlLink;    

    Data type
        None   
               
    Description
        This function generates a link for an external url.
         
        Optional attributes can be added:
         
        - link = string; The string will be used for the link instead of the
          field value.
         
        - fieldLink = fieldName; Sets the attribute "link" with the content of
          the field whose name is given by fieldName.
         
        - message = string; Message associated with the link.
         
        - fieldMessage = fieldName; Sets the attribute "message" with the
          content of the field whose name is given by fieldName.
   


.. _functions.makeXmlLabel:

func = makeXmlLabel;
====================

.. container:: table-row

    Property
        func = makeXmlLabel; 
        
    Data type
        None         
              
    Description
        This function generates the label from a xml language file. It works
        with the following parameter:
         
        - xmlLabel = string; the string is the label definition. For example,
          assume that the value comes from a selectorbox whose label definition
          is in the file locallang\_db.xml in the extension "my\_ext". Assume
          also that the field is "my\_field". Then, to obtain the label one has
          to write
         
        ::
         
            xmlLabel = LLL:EXT:my_ext/locallang_db.xml:tx_myext.my_field.I.;