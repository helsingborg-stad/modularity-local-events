import { createViteConfig } from "vite-config-factory";

const entries = {
        'css/modularity-local-events': './source/sass/modularity-local-events.scss',
};

export default createViteConfig(entries, {
	outDir: "assets/dist",
	manifestFile: "manifest.json",
});
