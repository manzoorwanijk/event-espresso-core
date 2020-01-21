import { useApolloClient } from '@apollo/react-hooks';
import { renderHook, act } from '@testing-library/react-hooks';

import useCacheRehydration from '../../initialization/useCacheRehydration';
import useUpdateTicketList from '../useUpdateTicketList';
import useTicketQueryOptions from '../../queries/tickets/useTicketQueryOptions';
import useTickets from '../../queries/tickets/useTickets';
import useTicketIds from '../../queries/tickets/useTicketIds';
import { ApolloMockedProvider } from '../../../context';

describe('useUpdateTicketList', () => {
	it('checks for tickets cache update', async () => {
		const wrapper = ApolloMockedProvider();
		const { result } = renderHook(
			() => {
				useCacheRehydration();
				return {
					queryOptions: useTicketQueryOptions(),
					ticketlist: useTickets(),
					cacheUpdater: useUpdateTicketList(),
					client: useApolloClient(),
				};
			},
			{
				wrapper,
			}
		);

		const ticketlist = result.current.ticketlist;

		const ticket = { ...ticketlist[0], id: ticketlist[0].id + '-alpha' };

		// add ticket to the list.
		const nodes = [...ticketlist, ticket];

		act(() => {
			result.current.cacheUpdater({
				...result.current.queryOptions,
				data: {
					espressoTickets: {
						__typename: 'EspressoRootQueryTicketsConnection',
						nodes,
					},
				},
			});
		});

		const cache = result.current.client.extract();
		const { result: cacheResult } = renderHook(
			() => {
				const client = useApolloClient();
				// restore the cache from previous render
				client.restore(cache);
				return useTicketIds();
			},
			{
				wrapper,
			}
		);

		const cachedTicketIds = cacheResult.current;

		expect(cachedTicketIds.length).toBe(ticketlist.length + 1);

		expect(cachedTicketIds).toContain(ticket.id);
	});
});