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


String
------

======================================================= =========== ============ ==== ====
Property                                                Data type   Default      Plus Mvc
======================================================= =========== ============ ==== ====
:ref:`String.size`                                      Integer     30           Yes  Yes
:ref:`String.keepZero`                                  Boolean     0            Yes  No
======================================================= =========== ============ ==== ====

.. _String.size:

size
^^^^
   
.. container:: table-row

  Property
    size
  
  Data type
    Integer

  Description
    Size of the field.
   
  Default
    30


.. _String.keepZero:

keepZero
^^^^^^^^

.. container:: table-row

  Property
    keepZero
     
  Data type
    Boolean
    
  Description
    If set and the field is equal to zero the "0" is displayed otherwise
    an empty field is displayed.
     
  Default
    0
