import TraceLLM from "../components/TraceLLM"
import { Navigate, useLocation } from "react-router-dom"

export default function SingleTrace() {
    const location = useLocation();
    const { state } = location || {};

    if (!state) {
        return <Navigate to="/traces" />
    }

    return (
        <section className="h-full flex flex-col p-6 gap-8">
            <h1 className="text-3xl font-bold text-gray-900">Trace for resources</h1>
            <TraceLLM title={state.title} id={state.id} label={state.label.label} />
        </section>
    )
}
