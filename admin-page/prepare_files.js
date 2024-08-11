// prepare_files.js
const fs = require("fs");
const path = require("path");
const fastGlob = require("fast-glob");

const buildDir = path.resolve(__dirname, "build/static");
const destDir = path.resolve(__dirname, "../assets");

async function MoveJS() {
	try {
		const files = await fs
			.readdirSync(buildDir + "/js")
			.filter((fn) => fn.startsWith("main") && fn.endsWith(".js"));

		files.forEach(async (file) => {
			if (!fs.existsSync(destDir + "/js")) {
				fs.mkdirSync(destDir + "/js", { recursive: true });
			}

			fs.rename( buildDir + "/js/" + file, destDir + "/js/" + file, (err) => {
				if (err) console.error("Erro ao mover arquivo:", err);

				fs.rename(destDir + "/js/" + file, destDir + "/js/main.js", (err) => {
					if (err) console.error("Erro ao renomear arquivo:", err);
				});
			});
		});
	} catch (err) {
		console.error("Erro ao buscar arquivos:", err);
	}
}

async function MoveCSS() {
	try {
		const files = await fs
			.readdirSync(buildDir + "/css")
			.filter((fn) => fn.startsWith("main") && fn.endsWith(".css"));

		files.forEach(async (file) => {
			if (!fs.existsSync(destDir + "/css")) {
				fs.mkdirSync(destDir + "/css", { recursive: true });
			}

			fs.rename( buildDir + "/css/" + file, destDir + "/css/" + file, (err) => {
				if (err) console.error("Erro ao mover arquivo:", err);

				fs.rename(destDir + "/css/" + file, destDir + "/css/main.css", (err) => {
					if (err) console.error("Erro ao renomear arquivo:", err);
				});
			});
		});
	} catch (err) {
		console.error("Erro ao buscar arquivos:", err);
	}
}

MoveJS();
MoveCSS();