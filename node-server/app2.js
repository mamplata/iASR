const { NFC } = require('nfc-pcsc');
const nfc = new NFC();

nfc.on('reader', reader => {
    console.log(`Reader detected: ${reader.name}`);

    reader.on('card', async card => {
        console.log(`Card detected: ${card.uid}`);

        const block = 4; // Block to write data
        const keyType = 0x60; // Key A
        const key = Buffer.from([0xff, 0xff, 0xff, 0xff, 0xff, 0xff]); // Default key

        try {
            await reader.authenticate(block, keyType, key);
            console.log('Authentication successful!');

            // Write an NDEF-like text record
            const textToWrite = "Hello NFC!";
            const data = Buffer.alloc(16, 0); // 16-byte block
            data.write(textToWrite, 0, 'utf-8');

            await reader.write(block, data, 16);
            console.log(`Data written: "${textToWrite}"`);

            // Read back the data
            let readData = await reader.read(block, 16, 16);
            readData = readData.toString('utf-8').replace(/\0/g, '').trim();
            console.log(`Read Data: "${readData}"`);

        } catch (err) {
            console.error('Error:', err);
        }
    });

    reader.on('error', err => console.error(`Reader error: ${err.message}`));
    reader.on('end', () => console.log(`Reader ${reader.name} removed.`));
});

nfc.on('error', err => console.error(`NFC error: ${err.message}`));
