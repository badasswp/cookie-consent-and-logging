declare global {
	var cookieConsentAndLogging: {
    isEnabled: boolean;
    cookies: {
      id: string;
    }[]
	};
}

export {};
