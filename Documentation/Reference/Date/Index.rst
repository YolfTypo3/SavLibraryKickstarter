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


Date
----


======================================================= =========== ============ ==== ====
Property                                                Data type   Default      Plus Mvc
======================================================= =========== ============ ==== ====
:ref:`Date.format`                                      Date format %d/%m/%Y     Yes  Yes
:ref:`Date.noDefault`                                   Boolean     0            Yes  Yes
======================================================= =========== ============ ==== ====


.. _Date.format:

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

        Example: full weekday and month names plus year

        ::

            format = %A %B %Y;

    Default
        %d/%m/%Y


.. _Date.noDefault:

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

