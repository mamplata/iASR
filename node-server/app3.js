const express = require("express");
const http = require("http");
const { Server } = require("socket.io");
const { NFC } = require("nfc-pcsc");

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

const nfc = new NFC();
let nfcReader = null;
let pendingStudentID = null;
const registeredStudents = []; 

nfc.on("reader", (reader) => {
  console.log(`NFC Reader detected: ${reader.name}`);
  nfcReader = reader;

  reader.on("card", (card) => {
    if (!pendingStudentID) {
      console.log("No Student ID provided before scanning.");
      return;
    }

    console.log(`Card detected for Student ID ${pendingStudentID}: ${card.uid}`);

    // Save the Student ID and NFC UID
    const studentRecord = { studentID: pendingStudentID, nfcUID: card.uid };
    registeredStudents.push(studentRecord);

    // Emit updated student list to all clients
    io.emit("studentRegistered", registeredStudents);

    // Reset pending Student ID
    pendingStudentID = null;
  });

  reader.on("error", (err) => console.error(`Reader error: ${err.message}`));
  reader.on("end", () => console.log(`Reader ${reader.name} removed.`));
});

nfc.on("error", (err) => console.error(`NFC error: ${err.message}`));

io.on("connection", (socket) => {
  console.log(`User connected: ${socket.id}`);

  socket.on("registerStudent", (studentID) => {
    console.log(`Student ID received: ${studentID}`);
    pendingStudentID = studentID;
    socket.emit("nfcStatus", "Tap your NFC card now!");
  });

  socket.on("disconnect", () => {
    console.log(`User disconnected: ${socket.id}`);
  });
});

server.listen(3000, () => {
  console.log("Socket.io server running on port 3000");
});
