import { useParams } from "react-router-dom";

function Group() {
  const { id } = useParams();

  return (
    <div>
      <h2>Detalle de {id}</h2>
    </div>
  );
}

export default Group;