.. include:: ../../Includes.txt

.. _string:

======
String
======

======================================================= =========== ============ ==== ====
Property                                                Data type   Default      Plus Mvc
======================================================= =========== ============ ==== ====
:ref:`string.eval`                                      String      None         Yes  No
:ref:`string.size`                                      Integer     30           Yes  Yes
:ref:`string.keepZero`                                  Boolean     0            Yes  No
:ref:`string.toLower`                                   Boolean     0            Yes  No
:ref:`string.toUpper`                                   Boolean     0            Yes  No
:ref:`string.trim`                                      Boolean     0            Yes  No
======================================================= =========== ============ ==== ====

.. _string.eval:

eval
====
   
.. container:: table-row

  Property
    eval
  
  Data type
    String

  Description
    The field is evaluated. Available evaluations are:
    
    - ``lower`` (diplays the field in lowercase)
    - ``password`` (replaces the field by \*\*\*\*\*\*\* when not edited)
    - ``trim`` (diplays the trimmed field)
    - ``upper`` (diplays the field in uppercase)   
    
    Evaluations can be comma-separated.   
   
  Default
    None

.. _string.size:

size
====
   
.. container:: table-row

  Property
    size
  
  Data type
    Integer

  Description
    Size of the field.
   
  Default
    30


.. _string.keepZero:

keepZero
========

.. container:: table-row

  Property
    keepZero
     
  Data type
    Boolean
    
  Description
    If set and the field is equal to zero the ``0`` is displayed otherwise
    an empty field is displayed.
     
  Default
    0
    
.. _string.toLower:

toLower
=======

.. container:: table-row

  Property
    toLower
     
  Data type
    Boolean
    
  Description
    If set the field is converted to the lowercase when saved (to be used in ``Edit view``).
     
  Default
    0 
    
.. _string.toUpper:

toUpper
=======

.. container:: table-row

  Property
    toUpper
     
  Data type
    Boolean
    
  Description
    If set the field is converted to the uppercase when saved (to be used in ``Edit view``).
     
  Default
    0       

.. _string.trim:

trim
====

.. container:: table-row

  Property
    trim
     
  Data type
    Boolean
    
  Description
    If set the field is trimmed when saved (to be used in ``Edit view``).
     
  Default
    0       
              