
================ Obtener Configuración ================

GET: /api.php/contract/{idContract}

Descripción: Obtiene la configuración del contrato

Query Params:
    idContract: id del contrato

================ Configurar y Firmar ================

POST: /api.php/contract/{idContract}
Body:
{
    "config": {
        "name": "Nombre del contrato",
        "language": "es",
        "validationRequired": false,
        "negotiate": true,
        "allowAttachments": false,
        "stampNom": true,
        "notificationType": "email",
        "signatureType": "autograph",
        "password": "C0ntRa5eÑ4",
        "webhook": "https://test.url.com"
    },
    "variables": {
        "participantId_1": {
            "var_1": "nuevo valor",
            "var_2": "nuevo valor"
        },
        "participantId_2": {
            "var_1": "nuevo valor",
            "var_2": "nuevo valor"
        }
    },
    "participants": {
        "participantId_1":  {
            "name": "participant 1",
            "email": "participant_1@trato.io",
            "phone": "5555555555",
            "representative": "",
            "obligation": "individual"
        },
        "participantId_2": {
            "name": "participant 2",
            "email": "participant_1@trato.io",
            "phone": "5555555555",
            "representative": "",
            "obligation": "individual"
        }
    }
}

Descripción: Configura el contrato y lo envía a firmar

Query Params:
    idContract: id del contrato

Body:
    config: (no requerido)
        name: Nombre del contrato
        language: Idioma en el cual se realizará el envío de notificaciones. Las opciones disponibles son (es: Español/en: Inglés). 
        validationRequired: Indica si la firma del documento requerirá validaci ón previa. Las opciones disponibles son (true/false). 
        negotiate: Indica si el documento será negociable durante el proceso de la firma. Las opciones disponibles son (true/false). 
        allowAttachments: Permitir a los participantes añadir anexos adicionales a los configurados en la plantilla. Las opciones disponibles son (true/false). 
        stampNom: Incluir la constancia NOM-151 como parte del contrato. Las opciones disponibles son (true/false). 
        notificationType: Tipo de notificaciones a enviar en cada evento del contrato. Las opciones disponibles son (email/sms). 
        signatureType: Tipo de firma con la cual se firmará el contrato. Las opciones disponibles son (autograph: Firma Autógrafa Digitalizada/certificate: Firma Electrónica Avanzada/none: Sin Firma). 
        password: Contraseña con la cual se protegerá el documento. Esta será compartida a todos los participantes para que puedan acceder al mismo. 
        webhook: URL a la cual TRATO realizará una petición una vez que el contrato ha sido firmado por todos los participantes. La llamada es por medio del método HTTP POST y se enviará como parte del cuerpo el identificador del contrato. 
    variables: (no requerido)
        participantId_1: Es el id del participante        
            var_1: (nombre de variable)
    participants: (no requerido)
        participantId_1: Es el id del participante