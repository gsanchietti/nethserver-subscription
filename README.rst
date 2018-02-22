=======================
nethserver-subscription
=======================

Manager NethServer Enterprise subscription

Database
========

Configuration is stored inside the ``configuration`` database under the ``subscription`` key.

Properties:

- ``AlertsUrl``: URL used to send alerts and heartbeat
- ``AlertsAutoUpdates``: if set to ``enabled``, custom alerts will be downloaded each night from ``AlertsUrl``.
- ``InventoryUrl``: URL used to send server inventory
- ``SystemId``: system unique id

Example: ::

  subscription=configuration
    AlertsAutoUpdates=enabled
    AlertsUrl=http://my.nethserver.org/api/alerts
    InventoryUrl=http://my.nethserver.org/api/alerts
    SystemId=11412232-2602-4d5d-9f4a-d28d54ce6dbc

