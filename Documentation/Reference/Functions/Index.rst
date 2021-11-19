.. include:: ../../Includes.txt

.. _functions:

=========
Functions
=========

Functions are applied to the value of the field. They can be also
applied to left and right contents. In this case, ``Lef`` or ``Right``
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
          the php-function strftime(). By defaut, ``%d/%m/%Y`` and ``%d/%m/%Y %H:%M`` are 
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
         
        - fieldMessage = fieldName; Sets the attribute ``message`` with the
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
        field. It will open the ``Single`` view associated with the selected
        item in another extension. The following attributes must be provided:
         
        - ext = string; String is the extension name followed by the form name.
          Example ``myext_intranet``.
         
        - pageId = integer; Integer is the page id where the extension is the
          content element.
         
        - contentId = integer; Integer is the content id of the extension.
         
        Optional attributes can be added:
         
        - folderTab = string; If the extension
          uses serveral folders, string is the folder tab name.
          
        - page = string; Alias to folderTab. 
          
        - linkAccessRestrictedPages = 1; The link is built even if the page is protected.        
                  
        - setUid = integer; The integer defines the item uid associated with the
          link.
         
        - valueIsUid = 1; The field value is used as the uid of the item
          associated with the link.
          
		- subformUidForeignInLink = integer; Makes it possible to access to
		  a subform item, integer is the uid of the subform item.            
         
        - restrictLinkTo = ###usergroup=group_name###; The link will be
          displayed if the user belongs to the ``group_name``.
         
        - restrictLinkTo = ###usergroup!=group_name###; The link will be
          displayed if the user does not belong to the ``group_name``.
   


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
         
        - folder = string; String is the folder where the file should be.
         
        - width = integer; Width of the image in pixels.
         
        - height = integer; Height of the image in pixels.
         
        - alt = string; String is the ``alt`` attribute of the image.
         
        - fieldAlt = field_name; The ``alt`` attribute is the value of the
          fieldname for the current record.
   


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
        field. It will open the ``Single`` view associated with the selected
        item.
         
        Optional attributes can be added:
         
        - folderTab = string; If the extension
          uses serveral folders, string is the folder tab name.
          
        - page = string; Alias to folderTab.           
         
        - updateForm = 1; Makes it possible to open an ``update`` view instead of
          the ``Single`` view (**Not yet implemented in SAV Library Mvc**).
         
        - inputForm = 1; Makes it possible to open an ``Edit`` view instead
          of the ``Single`` view.
         
        - setUid = integer; The integer defines the item uid associated with the
          link.
         
        - valueIsUid = 1; The field value is used as the uid of the item
          associated with the link (**Not yet implemented in SAV Library Mvc**).
          
		- subformUidForeignInLink = integer; Makes it possible to access to
		  a subform item, integer is the uid of the subform item.       



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
          ``message`` with the content of the field whose
          name is given by fieldName.
         
        - setUid = integer; The integer defines the 
          item uid associated with the link.
         
        - valueIsUid = 1; The field value is used as 
          the uid of the item associated with the link.


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
         
        - windowUrl = string; String is the url. The marker
          ``###special[fieldname]###`` from selectors can be used. This parameter is
          not necessary if the field is an image.
         
        Optional attributes can be added:
         
        - windowText = string; String is added above the image. The marker
          ``###special[fieldname]###`` from selectors can be used.
         
        - windowBodyStyle = string; String is added as the style attribute
          to the body html tag. Do not forget to use ``\\;`` for style attributes,
          since the semi-colon is use to split field attributes, and do not
          forget to end your definition by a semi-colon. Example:
         
        ::
         
            windowBodyStyle = fontweight:bold\\;font-color:blue\\;;
         
        - message = string; Message associated with the link.
         
        - fieldMessage = fieldName; Sets the attribute ``message`` with the
          content of the field whose name is given by ``fieldName``.
     


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
         
        - link = string; The string is used for the link instead of the
          field value.
         
        - fieldLink = fieldName; Sets the attribute ``link`` with the content of
          the field whose name is given by fieldName.
         
        - message = string; Message associated with the link.
         
        - fieldMessage = fieldName; Sets the attribute ``message`` with the
          content of the field whose name is given by ``fieldName``.
   


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
        with the following parameters:
         
        - xmlLabel = string; The string is the label definition. For example,
          assume that the value comes from a selectorbox whose label definition
          is in the file ``locallang_db.xlf`` in the extension ``my_ext``. Assume
          also that the field is ``my_field``. Then, to obtain the label one has
          to write
         
        ::
         
            xmlLabel = LLL:EXT:my_ext/Resources/Private/Language/locallang_db.xlf:tx_myext.my_field.I.;
            
        - rawValue = 1; The raw alue, i.e. the value stored in the table, is used instead of the rendered one.