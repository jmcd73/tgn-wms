INSERT INTO `settings`
(
`name`,
`setting`,
`comment`)
VALUES
('companyName', '100% Bottling Company', ''),
('DOCUMENTATION_ROOT', '/docs/help', '' ),
('bigNumberTemplateTokens', 'Setting in comment' , '{ "*COMPANY_NAME*": "companyName", "*OFFSET*": "offset", "*NUMBER*": "number", "*NUM_LABELS*": "quantity" }'),
('cabCartonTemplateTokens', 'Setting in comment','{ "*DESC*": "description", "*GTIN14*": "gtin14", "*NUM_LABELS*": "numLabels" }' ),
('cabLabelTokens','Setting in comment', '{ "*COMPANY_NAME*": "companyName", "*INT_CODE*": "internalProductCode", "*REF*": "reference", "*SSCC*": "sscc", "*DESC*": "description", "*GTIN14*": "gtin14", "*QTY*": "quantity", "*BB_HR*": "bestBeforeHr", "*BB_BC*": "bestBeforeBc", "*BATCH*": "batch", "*NUM_LABELS*": "numLabels" }'),
('GLABELS_ROOT', 'files/templates', ''),
('sscc_default_label_copies', 2, ''),
('plRefMaxLength', 8, ''),
('cooldown', 48, ''),
('MaxShippingLabels', 70, '');
