const express = require("express");
const http = require("http");
const socketIo = require("socket.io");

const app = express();
const server = http.createServer(app);

// Set up Socket.io
const io = socketIo(server, {
  cors: {
    origin: "http://localhost:5173", // Adjust to your Vue.js app's URL
    methods: ["GET", "POST"],
    allowedHeaders: ["Content-Type"],
    credentials: true,
  },
});

// Serve static files (Vue.js app and message.html)
app.use(express.static("public"));

// Handle the incoming message from the client (sent through message.html)
io.on("connection", (socket) => {
  console.log("A user connected");

  // Listen for the 'sendMessage' event from the client (message.html)
  socket.on("sendMessage", (message) => {
    console.log(`Message received from client: ${message}`);

    // Emit the message to all connected clients
    io.emit("newMessage", message);
  });

  // Handle disconnection
  socket.on("disconnect", () => {
    console.log("User disconnected");
  });
});

// Start server
server.listen(3000, () => {
  console.log("Server running on http://localhost:3000");
});
