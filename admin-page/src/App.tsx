import { HashRouter, Route, Routes } from "react-router-dom";
import ThemesPage from "./pages/Themes/ThemesPage";
import ModalContextProvider from "./components/global/modal/context/ModalContext";
import ColorsPage from "./pages/Colors/ColorsPage";
import ReactionsPage from "./pages/Reactions/ReactionsPage";

function App() {
	return (
		<ModalContextProvider>
			<HashRouter basename="/">
				<Routes>
					<Route path="/" element={ <ThemesPage /> } />
					<Route path="/colors" element={ <ColorsPage /> } />
					<Route path="/reactions" element={ <ReactionsPage /> } />
				</Routes>
			</HashRouter>
		</ModalContextProvider>
	);
}

export default App;
