import { CapacitorConfig } from '@capacitor/cli';

const config: CapacitorConfig = {
  appId: 'radio.capsao.app',
  appName: 'Radio Capsao',
  webDir: 'dist',
  server: {
    androidScheme: 'https'
  },
  plugins: {
    CapacitorHttp: {
      enabled: true,
    },
  },
};

export default config;
