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


Date and time
-------------


======================================================= =========== ============== ==== ====
Property                                                Data type   Default        Plus Mvc
======================================================= =========== ============== ==== ====
:ref:`DateAndTime.format`                               Date format %d/%m/%Y %H:%M Yes  Yes
:ref:`DateAndTime.noDefault`                            Boolean     0              Yes  Yes
======================================================= =========== ============== ==== ====



.. _DateAndTime.format:

format
^^^^^^

.. container:: table-row

    Property
        format       

    Data type
        Date format
  
    Description
        Sets a format to display the date. The format is the same as in
        strftime php function.
         
        Example: full weekday and month names plus year and time
         
        ::
         
        format = %A %B %Y at %H:%M;
     
    Default
        %d/%m/%Y %H:%M


.. _DateAndTime.noDefault:

noDefault
^^^^^^^^^

.. container:: table-row

    Property
        noDefault  

    Data type
        Boolean
        
    Description
        Do not display the default date.
   
    Default
        0