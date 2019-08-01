.. include:: ../../Includes.txt

.. _date:

====
Date
====


======================================================= =========== ============ ==== ====
Property                                                Data type   Default      Plus Mvc
======================================================= =========== ============ ==== ====
:ref:`date.format`                                      Date format %d/%m/%Y     Yes  Yes
:ref:`date.noDefault`                                   Boolean     0            Yes  Yes
======================================================= =========== ============ ==== ====


.. _date.format:

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

        Example: full weekday and month names plus year

        ::

            format = %A %B %Y;

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