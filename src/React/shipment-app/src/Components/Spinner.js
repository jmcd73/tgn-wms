import React from "react";
import Col from "react-bootstrap/Col";
import Row from "react-bootstrap/Row";
import PulseLoader from "react-spinners/PulseLoader";

const Spinner = (props) => {
  const { loading } = props;
  if (loading) {
    return (
      <Row>
        <Col lg={12}>
          <div className="text-center">
            <PulseLoader loading={loading} size={14} color={"#ddd"} />
          </div>
        </Col>
      </Row>
    );
  }
  return <></>;
};

export default Spinner;
