.. include:: ../../Includes.txt

.. _dateAndTime:

=============
Date and Time
=============

======================================================= =========== ============== ==== ====
Property                                                Data type   Default        Plus Mvc
======================================================= =========== ============== ==== ====
:ref:`dateAndTime.dateFormat`                           Date format %d/%m/%Y %H:%M Yes  Yes
:ref:`dateAndTime.noDefault`                            Boolean     0              Yes  Yes
======================================================= =========== ============== ==== ====

.. _dateAndTime.dateFormat:

dateFormat
==========

.. container:: table-row

    Property
        dateFormat       

    Data type
        Date format
  
    Description
        Sets a format to display the date. The format is the same as in
        strftime php function. 
        
        .. important::
        
        	It replaces the attribute `format` deprecated in SAV Library Kickstarter v12.
         
        Example: full weekday and month names plus year and time
         
        ::
         
        	dateFormat = %A %B %Y at %H:%M;
     
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