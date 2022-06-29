import Footer from "./layouts/Footer"
import Navbar from "./layouts/navbar/Navbar"
import {
    BrowserRouter,
    Routes,
    Route,
} from "react-router-dom";
import ScrollToTop from "./components/ScrollToTop"
import PrivateRoute from "./auth/PrivateRoute"
import { QueryClient, QueryClientProvider } from "react-query"

import { routesPrivate, routesPublic } from "./routes";
//import { routesPublic } from "./routes";
const queryClient = new QueryClient({
    defaultOptions: {
        queries: {
            retryDelay: 0,
            refetchOnWindowFocus: false,
        },
    },
})

function App() {
    return (
        <>
            <QueryClientProvider client={queryClient}>
                <BrowserRouter>
                    <ScrollToTop />
                    <div className="flex flex-col justify-between h-screen">
                        <Navbar />
                        <div className="grow">
                            <Routes>

                                {routesPublic.map((item) => (
                                    <Route
                                        key={item.path}
                                        path={item.path}
                                        element={<item.Component />}

                                    />
                                ))}
                                {routesPrivate.map((item) => (
                                    <Route
                                        key={item.path}
                                        path={item.path}
                                        element={<PrivateRoute Component={item.Component} />}
                                    />
                                ))}

                            </Routes>

                        </div>
                        <Footer />
                    </div>
                </BrowserRouter>
            </QueryClientProvider >
        </>
    )
}

export default App
