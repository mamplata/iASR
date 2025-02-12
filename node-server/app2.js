const { NFC } = require("nfc-pcsc");
const readline = require("readline-sync");
const crypto = require("crypto");
const { machineIdSync } = require("node-machine-id");
const macaddress = require("macaddress");
const si = require("systeminformation");

// Generate a unique fingerprint based on machine id, MAC address, and hardware UUID.
async function generateFingerprint() {
    // Get OS machine ID (original value)
    const machineId = machineIdSync({ original: true });
    
    // Get the primary MAC address from the first non-internal interface
    const mac = await macaddress.one();
    
    // Get the hardware UUID (if available)
    const uuidData = await si.uuid();
    const hardwareUUID = uuidData.hardware || '';
    
    // Combine the values and create a SHA-256 hash
    return crypto.createHash('sha256').update(machineId + mac + hardwareUUID).digest('hex');
}

// This function checks if the device fingerprint matches the expected fingerprint.
async function startSystem() {
    const fingerprint = await generateFingerprint();
    console.log("Device Fingerprint:", fingerprint);
    
    // Replace with your authorized device's fingerprint.
    const expectedFingerprint = "00d499bcd9327060caec1ebdf57e09845e1442f1bd82107027788d9d9d145b0e";
    
    if (fingerprint !== expectedFingerprint) {
        console.error("Invalid device fingerprint. Exiting system.");
        process.exit(1);
    } else {
        console.log("Valid device fingerprint. Starting NFC service...");
        startNFC();
    }
}

// This function starts the NFC service using nfc-pcsc.
function startNFC() {
    const nfc = new NFC();

    nfc.on("reader", (reader) => {
        console.log(`Reader detected: ${reader.name}`);

        reader.on("card", async (card) => {
            console.log(`Card detected: ${card.uid}`);

            const block = 4; // Data storage block
            const keyType = 0x60; // Key A
            const key = Buffer.from([0xff, 0xff, 0xff, 0xff, 0xff, 0xff]); // Default key

            try {
                await reader.authenticate(block, keyType, key);
                console.log("Authentication successful!");

                while (true) {
                    console.log("\nChoose an option:");
                    console.log("1. Create (Write Data)");
                    console.log("2. Read Data");
                    console.log("3. Update Data");
                    console.log("4. Delete Data");
                    console.log("5. Exit");
                    const choice = readline.question("Enter choice: ");

                    switch (choice) {
                        case "1": // Create (Write)
                            const textToWrite = readline.question("Enter text to write: ");
                            let data = Buffer.alloc(16, 0); // 16-byte block
                            data.write(textToWrite, 0, "utf-8");
                            await reader.write(block, data, 16);
                            console.log(`Data written: "${textToWrite}"`);
                            break;

                        case "2": // Read
                            let readData = await reader.read(block, 16, 16);
                            readData = readData.toString("utf-8").replace(/\0/g, "").trim();
                            console.log(`Read Data: "${readData}"`);
                            break;

                        case "3": // Update
                            let existingData = await reader.read(block, 16, 16);
                            existingData = existingData.toString("utf-8").replace(/\0/g, "").trim();
                            console.log(`Current Data: "${existingData}"`);
                            const newData = readline.question("Enter new data: ");
                            let updateBuffer = Buffer.alloc(16, 0);
                            updateBuffer.write(newData, 0, "utf-8");
                            await reader.write(block, updateBuffer, 16);
                            console.log(`Data updated to: "${newData}"`);
                            break;

                        case "4": // Delete (Clear)
                            let clearBuffer = Buffer.alloc(16, 0); // Empty buffer
                            await reader.write(block, clearBuffer, 16);
                            console.log("Data deleted from NFC tag.");
                            break;

                        case "5": // Exit
                            console.log("Exiting...");
                            return;

                        default:
                            console.log("Invalid choice. Try again.");
                    }
                }
            } catch (err) {
                console.error("Error:", err);
            }
        });

        reader.on("error", (err) => console.error(`Reader error: ${err.message}`));
        reader.on("end", () => console.log(`Reader ${reader.name} removed.`));
    });

    nfc.on("error", (err) => console.error(`NFC error: ${err.message}`));
}

// Start by checking the device fingerprint.
startSystem();
