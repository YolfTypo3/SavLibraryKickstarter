.. include:: ../../Includes.txt

.. _date:

====
Date
====


======================================================= =========== ============ ==== ====
Property                                                Data type   Default      Plus Mvc
======================================================= =========== ============ ==== ====
:ref:`date.dateFormat`                                  Date format %d/%m/%Y     Yes  Yes
:ref:`date.noDefault`                                   Boolean     0            Yes  Yes
======================================================= =========== ============ ==== ====


.. _date.dateFormat:

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

        Example: full weekday and month names plus year

        ::

            dateFormat = %A %B %Y;

    Default
        %d/%m/%Y


.. _date.noDefault:

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