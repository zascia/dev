import React from 'react';
import logo from './logo.svg';
import './App.css';

let a: number = 10;
let a: string = '10';
let isSamurai: boolean | null = true;

let names: Array<string> = ["Name1", "Name2", "Name3"];

let sex: "male" | "female";

type AddressType = {
  city?: string | null
  country: string | null
}

let initialState = {
  name: null as number | null,
  age: null as string | null,
  isSamurai: null as boolean | null,
  address: {
    city: null,
    country: null
  } as AddressType,
  counter: 0
}
export type InitialStateType = typeof initialState;
let state: InitialStateType = {
  address: {
    city: null,
    country: null
  }
}

let GET_TASKS = 'APP/GETTASKS';
type GetTasksActionType = {
  id: number,
  type: typeof GET_TASKS;
}

let action: GetTasksActionType = {
  type: GET_TASKS,
  id: 9
}


const summ = (a: number, b: number) => {
  return a + b;
}

function App() {
  return (
    <div className="App">
      <header className="App-header">
        <img src={logo} className="App-logo" alt="logo" />
        <p>
          Edit <code>src/App.tsx</code> and save to reload.
        </p>
        <a
          className="App-link"
          href="https://reactjs.org"
          target="_blank"
          rel="noopener noreferrer"
        >
          Learn React
        </a>
      </header>
    </div>
  );
}

export default App;
