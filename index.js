const express = require("express");
const multer = require("multer");
const path = require("path");
const fs = require("fs");

const app = express();

// Middleware
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, "public")));
app.use("/uploads", express.static(path.join(__dirname, "uploads")));

// Set view engine
app.set("view engine", "ejs");
app.set("views", path.join(__dirname, "views"));

// Multer for video uploads
const storage = multer.diskStorage({
    destination: "./uploads/",
    filename: (req, file, cb) => {
        cb(null, `${Date.now()}-${file.originalname}`);
    },
});
const upload = multer({ storage });

// Admin Panel
app.get("/admin", (req, res) => {
    const videoFiles = fs.readdirSync("./uploads").sort((a, b) => fs.statSync(`./uploads/${b}`).mtime - fs.statSync(`./uploads/${a}`).mtime);
    res.render("admin", { videos: videoFiles });
});

// Upload Videos
app.post("/upload", upload.single("video"), (req, res) => {
    if (!req.file) {
        return res.status(400).send("No video uploaded.");
    }
    res.redirect("/admin");
});

// Public View
app.get("/", (req, res) => {
    const videoFiles = fs.readdirSync("./uploads").sort((a, b) => fs.statSync(`./uploads/${b}`).mtime - fs.statSync(`./uploads/${a}`).mtime);
    res.render("public", { videos: videoFiles });
});

// Theme Upload (Admin Feature)
app.post("/upload-theme", upload.single("theme"), (req, res) => {
    if (req.file && req.file.originalname.endsWith(".css")) {
        fs.renameSync(req.file.path, path.join(__dirname, "public/css/style.css"));
        res.redirect("/admin");
    } else {
        res.status(400).send("Invalid theme file. Only CSS files are allowed.");
    }
});

// Start server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server running on http://localhost:${PORT}`);
});
