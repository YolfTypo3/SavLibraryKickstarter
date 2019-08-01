.. include:: ../../Includes.txt

.. _dateAndTime:

=============
Date and Time
=============

======================================================= =========== ============== ==== ====
Property                                                Data type   Default        Plus Mvc
======================================================= =========== ============== ==== ====
:ref:`dateAndTime.format`                               Date format %d/%m/%Y %H:%M Yes  Yes
:ref:`dateAndTime.noDefault`                            Boolean     0              Yes  Yes
======================================================= =========== ============== ==== ====



.. _dateAndTime.format:

format
======

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


.. _dateAndTime.noDefault:

noDefault
=========

.. container:: table-row

    Property
        noDefault  

    Data type
        Boolean
        
    Description
        Do not display the default date.
   
    Default
        0