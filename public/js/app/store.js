/**
 * Created by anggakes on 8/25/17.
 */

// localStorage Stuff
const loadState = () => {
    try {
        const serializedState = localStorage.getItem('vue_state');
        if (serializedState === null) {
            return undefined;
        }
        return JSON.parse(serializedState);
    } catch (err) {
        return undefined;
    }
};

const saveState = (state) => {
    try {
        const serializedState = JSON.stringify(state);
        localStorage.setItem('vue_state', serializedState);
    } catch (err) {
        console.error(`Something went wrong: ${err}`);
    }
}

const store = new Vuex.Store({
    state: loadState(),
    mutations: {
        setLogin (state, data) {

            state.access_token = data.access_token;
            state.user = data.user;
            state.expires_in = data.expired_in;

            saveState(state);
        }
    }
})