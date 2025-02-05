const express = require("express");
const http = require("http");
const socketIo = require("socket.io");
const { NFC } = require("nfc-pcsc"); // Import nfc-pcsc
const path = require("path");

const app = express();
const server = http.createServer(app);

// Socket.io CORS configuration
const io = socketIo(server, {
  cors: {
    origin: "http://localhost:5173", // The URL of your Vue.js app
    methods: ["GET", "POST"],
    allowedHeaders: ["Content-Type"],
    credentials: true,
  },
});

// Initialize NFC reader
const nfc = new NFC(); // Create NFC instance

// Store the UID of detected cards
let cardUids = [];

// Handle NFC card detection
nfc.on("reader", (reader) => {
  console.log(`Reader detected: ${reader.reader.name}`);

  // When a card is found
  reader.on("card", (card) => {
    console.log(`Card detected: ${card.uid}`);

    // Emit the UID to connected clients
    io.emit("newCard", card.uid);
  });

  // Handle card removal
  reader.on("card.off", (card) => {
    console.log(`Card removed: ${card.uid}`);
  });

  reader.on("error", (err) => {
    console.error("Error:", err);
  });

  reader.on("end", () => {
    console.log("Reader disconnected");
  });
});

nfc.on("error", (err) => {
  console.error("NFC Error:", err);
});

// Serve static files (Vue.js or plain front-end)
app.use(express.static(path.join(__dirname, "public")));

// Start server
server.listen(3000, () => {
  console.log("Server running on http://localhost:3000");
});
