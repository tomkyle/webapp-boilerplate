// lighthouserc.js
//
// Configuration:
// https://github.com/GoogleChrome/lighthouse-ci/blob/main/docs/configuration.md
//
module.exports = {
  ci: {
    collect: {
      startServerCommand: 'docker compose up',
      url: [
        'https://localhost'
      ],
      numberOfRuns: 5
    },
    upload: {
      target: 'filesystem',
      outputDir: './tests/lhci',
      reportFilenamePattern: "%%HOSTNAME%%_%%PATHNAME%%_%%DATE%%.%%EXTENSION%%"
    },
  },
};
