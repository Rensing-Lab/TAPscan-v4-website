SELECT TAP.name, Description.name, Description.year, Description.descr, GROUP_CONCAT(Reference.ref SEPARATOR '","'), TAPclass.name
FROM TAP
INNER JOIN Description ON TAP.id=Description.tap_id
INNER JOIN Reference ON TAP.id=Reference.tap_id
INNER JOIN TAPclass ON TAP.class_id=TAPclass.id
GROUP BY TAP.name;
