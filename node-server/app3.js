const express = require("express");
const http = require("http");
const { Server } = require("socket.io");

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

io.on("connection", (socket) => {
  console.log(`User connected: ${socket.id}`);

  socket.on("event1", (data) => {
    console.log("Received Event 1:", data);
    io.emit("responseEvent1", { message: "Event 1 received", data });
  });

  socket.on("event2", (data) => {
    console.log("Received Event 2:", data);
    io.emit("responseEvent2", { message: "Event 2 received", data });
  });

  socket.on("disconnect", () => {
    console.log(`User disconnected: ${socket.id}`);
  });
});

server.listen(3000, () => {
  console.log("Socket.io server running on port 3000");
});
