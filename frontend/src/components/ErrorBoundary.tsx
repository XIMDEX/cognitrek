import { useRouteError } from "react-router-dom";

const ErrorBoundary = () => {
  const error = useRouteError() as { message?: string };

  return (
    <section>
      <h1>Error Boundary</h1>
      <small>{error?.message}</small>
    </section>
  );
};

export default ErrorBoundary;