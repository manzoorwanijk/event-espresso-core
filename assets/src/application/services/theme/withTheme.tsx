import React from 'react';

import { AnyObject } from '@application/services/utilities/types';
import ThemeProvider from './ThemeProvider';

const withTheme = <P extends AnyObject>(Component: React.ComponentType<P>): React.FC<P> => {
	const WrappedComponent: React.FC<P> = (props) => {
		return (
			<ThemeProvider>
				<Component {...props} />
			</ThemeProvider>
		);
	};
	return WrappedComponent;
};

export default withTheme;
