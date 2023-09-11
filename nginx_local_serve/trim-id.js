function trimId(s)
{
    return s.replace(/^%A/, "").split("=")[0];
}

export default {trimId};

