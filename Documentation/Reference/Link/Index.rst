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


Link
----


======================================================= =========== ============ ==== ====
Property                                                Data type   Default      Plus Mvc
======================================================= =========== ============ ==== ====
:ref:`Link.fieldLink`                                   Field name               Yes  Yes
:ref:`Link.fieldMessage`                                Field name               Yes  Yes
:ref:`Link.generateRTF`                                 Boolean     0            Yes  No
:ref:`Link.link`                                        String                   Yes  Yes
:ref:`Link.message`                                     String                   Yes  Yes
:ref:`Link.saveFileRTF`                                 String                   Yes  No
:ref:`Link.tableName.fieldName`                         String                   Yes  No
:ref:`Link.templateRTF`                                 String                   Yes  No
======================================================= =========== ============ ==== ====



.. _Link.fieldLink:

fieldLink
^^^^^^^^^

.. container:: table-row

    Property
        fieldLink
       
    Data type
      Field name
                 
    Description
      Sets the attribute "link" with the content of the field whose name is
      given by fieldName.
  

.. _Link.fieldMessage:

fieldMessage
^^^^^^^^^^^^
   
.. container:: table-row

    Property
        fieldMessage
   
    Data type
        fieldName
                
    Description
        Sets the attribute "message" with the content of the field whose name
        is given by fieldName.
    
  
.. _Link.generateRTF:

generateRTF
^^^^^^^^^^^

.. container:: table-row

    Property
        generateRTF
        
    Data type
        Boolean
         
    Description
        Sets the RTF generator.
       
    Default
        0


.. _Link.link:

link
^^^^

.. container:: table-row

    Property
        link
       
    Data type
        String
       
    Description
        The string will be used for the link instead of the field value.
   

.. _Link.message:

message
^^^^^^^

.. container:: table-row

    Property
        message

    Data type
        String  
       
    Description
        Message associated with the link.
   
    

.. _Link.saveFileRTF:

saveFileRTF
^^^^^^^^^^^

.. container:: table-row

    Property
        saveFileRTF
        
    Data type
        String
         
    Description
        Name under which the generated file will be saved. Field markers
        ###tableName.fieldName### or ###fieldName### (for aliases) can be
        used.
  

.. _Link.tableName.fieldName:

tableName.fieldName
^^^^^^^^^^^^^^^^^^^

.. container:: table-row

    Property
        tableName.fieldName
    
    Data type
        String
         
    Description
        String can be string1->string2 or NL-> string2
             
        In an rtf document, if the field marker ###tableName.fieldName###
        exists string1 will be replaced by string2. String1 can be NL (for the
        ASCII character LF).
             
        It may be useful when one wants to input data in a textarea and
        display them in one line with a given separator in the file.
   

  
.. _Link.templateRTF:

templateRTF
^^^^^^^^^^^

.. container:: table-row

    Property
        templateRTF
        
    Data type
        String   
        
    Description
        Defines the template to be used by the RTF generator. Field markers
        ###tableName.fieldName### or ###fieldName### (for aliases) can be
        used.
   

   




