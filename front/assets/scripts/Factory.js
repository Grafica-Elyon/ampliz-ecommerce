export default class Factory {
	static rule(name, message) {
		return {
			name,
			'rules': {
				required: {
					message,
				}
			}
		};
	}
}
