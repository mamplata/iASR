const express = require("express");
const http = require("http");
const { Server } = require("socket.io");
const { generateFingerprint } = require("./utils/fingerprint");
const { initializeNFC, pendingStudent } = require("./utils/nfcHandler"); // ✅ Import correctly

const app = express();
const server = http.createServer(app);
const io = new Server(server, {
  cors: {
    origin: ["http://localhost:8000", "http://127.0.0.1:8000"],
    methods: ["GET", "POST"],
    allowedHeaders: ["Content-Type"],
    credentials: true,
  },
});

// Check device fingerprint before initializing NFC
(async () => {
  try {
    const deviceFingerprint = await generateFingerprint();
    console.log("Generated Device Fingerprint:", deviceFingerprint);

    // Replace with your stored registered fingerprint
    const registeredFingerprint = '00d499bcd9327060caec1ebdf57e09845e1442f1bd82107027788d9d9d145b0e';

    if (deviceFingerprint !== registeredFingerprint) {
      console.error("❌ Device not registered. Blocking NFC access.");
      return; // Stop execution to prevent NFC initialization
    }

    console.log("✅ Device is registered. Enabling NFC scanning...");
    initializeNFC(io);
  } catch (err) {
    console.error("❌ Initialization error:", err);
  }
})();

// Socket.io setup
io.on("connection", (socket) => {
  console.log(`User connected: ${socket.id}`);

  socket.on("registerStudent", (studentID) => {
    console.log(`Student ID received: ${studentID}`);
    
    pendingStudent.id = studentID; // ✅ Now updates correctly!
    
    socket.emit("nfcStatus", "Tap your NFC card now!");
  });

  socket.on("disconnect", () => {
    console.log(`User disconnected: ${socket.id}`);
  });
});

// Start the server
server.listen(3000, () => {
  console.log("Socket.io server running on port 3000");
});
