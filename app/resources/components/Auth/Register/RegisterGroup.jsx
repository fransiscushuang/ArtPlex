import React, { useState } from "react";
import { useHistory } from "react-router-dom";
import { useForm } from "react-hook-form";
import axios from "axios";
import * as yup from "yup";

import Register from "./Register";
import CheckMail from "../CheckMail";
import { useEffect } from "react";

const RegisterGroup = () => {
  const history = useHistory();

  const schema = yup.object().shape({
    name: yup
      .string()
      .required("This field is required")
      .min(3, "Name too short")
      .matches(/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/g, "Invalid"),
    username: yup
      .string()
      .required("This field is required")
      .min(4, "Username too short")
      .max(30, "Username too long")
      .matches(
        /^[a-zA-Z0-9_.-]*$/,
        "Only allow dot , underscores , hyphen in username."
      ),
    email: yup
      .string()
      .required("This field is required")
      .email("Email is in invalid form"),
    password: yup
      .string()
      .required("This field is required")
      .matches(
        /^(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).{6,}$/,
        "Password length must be at least 6 characters include uppercase, lowercase, number "
      ),
  });

  const { register, handleSubmit, errors, watch } = useForm({
    validationSchema: schema,
  });

  const [email, setEmail] = useState("");
  const [auth, setAuth] = useState({ email: "", username: "" });

  const onSubmit = async (formData) => {
    let data = new FormData();
    data.append("name", formData.name);
    data.append("username", formData.username);
    data.append("email", formData.email);
    data.append("password", formData.password);
    const res = await axios.post("/api/actions/register.php", data);
    // console.log(res.data);
    if (res.data.success) {
      setAuth(res.data.error);
      sendMail();
    } else {
      setAuth(res.data.error);
    }
  };

  const sendMail = () => {
    const data = new FormData();
    data.append("email", email);
    data.append("type", "verify");
    axios.post("/api/actions/send_mail.php", data);
  };

  const goHome = () => {
    history.push("/");
    window.location.reload();
  };

  useEffect(() => {
    console.log(auth);
  }, [auth]);

  if (auth.email === null && auth.username === null) {
    return <CheckMail email={email} type={"verify"} />;
  } else {
    return (
      <Register
        register={register}
        handleSubmit={handleSubmit}
        onSubmit={onSubmit}
        errors={errors}
        auth={auth}
        goHome={goHome}
        setEmail={setEmail}
      ></Register>
    );
  }
};

export default RegisterGroup;
