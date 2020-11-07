const doctors = {
    namespaced: true,
    state() {
        return {
            doctors: [
                {
                    'name': 'Edilaine de Olveira Miguel',
                    'address': 'Av. Rio Branco',
                    'number': '1357',
                    'zipcode': '17526-693',
                    'neighborhood': 'Alto Cafezal',
                    'city': 'Marília',
                    'state': 'SP'
                },
                {
                    'name': 'Benedito Pilon',
                    'address': 'Rua Vinte e um de abril',
                    'number': '143',
                    'zipcode': '17516-170',
                    'neighborhood': 'Jardim Maria Izabel',
                    'city': 'Marília',
                    'sate': 'SP'
                },
                {
                    'name': 'Gisele Nicolielo Soria',
                    'address': 'Av.Rio Branco',
                    'number': '1132',
                    'zipcode': '17502-000',
                    'neighborhood': 'Alto Cafezal',
                    'city': 'Marília',
                    'sate': 'SP'
                },
                {
                    'name': 'Gisele César de Rossi',
                    'address': 'Av.Cascata',
                    'number': '47',
                    'zipcode': '17515-300',
                    'neighborhood': 'Jardim Maria Izabel',
                    'city': 'Marília',
                    'sate': 'SP'
                }
            ]
        }
    },
    mutations: {
        add(state, payload) {
            state.doctors = [...state.doctors, payload.doctor];
        }
    },
    actions: {
        add(context, payload) {
            context.commit('add', payload);
        }
    }
};

export default user;