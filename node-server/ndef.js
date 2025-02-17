const { NFC } = require("nfc-pcsc");
const ndef = require("ndef");

const nfc = new NFC();

nfc.on("reader", (reader) => {
    console.log(`🛠️ NFC Reader detected: ${reader.name}`);

    reader.on("card", async (card) => {
        console.log(`💳 Card detected: ${card.uid}`);

        try {
            // 📖 Read NDEF data from NFC tag
            let rawData = await reader.read(4, 48, 16); // Read 48 bytes from Block 4 (where NDEF usually starts)
            
            // Decode NDEF message
            let ndefMessage = ndef.decodeMessage(rawData);
            
            // 🔍 Display NDEF Records
            console.log("📡 NDEF Data:");
            ndefMessage.forEach((record, index) => {
                let decodedData;
                
                // Check record type
                if (record.type.toString() === "T") { // Text Record
                    decodedData = ndef.text.decodePayload(record.payload);
                } else if (record.type.toString() === "U") { // URI Record
                    decodedData = ndef.uri.decodePayload(record.payload);
                } else {
                    decodedData = record.payload.toString("utf-8");
                }

                console.log(`📝 Record ${index + 1}: Type: ${record.type}, Data: "${decodedData}"`);
            });
        } catch (err) {
            console.error("❌ Read Error:", err);
        }
    });

    reader.on("error", (err) => console.error(`Reader error: ${err.message}`));
    reader.on("end", () => console.log(`Reader ${reader.name} removed.`));
});

nfc.on("error", (err) => console.error(`NFC error: ${err.message}`));
