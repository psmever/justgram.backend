/* eslint-disable @typescript-eslint/camelcase */
import { Strategy as JwtStrategy, ExtractJwt } from 'passport-jwt';
import Users from '@src/models/Users';

const opts = {
    jwtFromRequest: ExtractJwt.fromAuthHeaderAsBearerToken(),
    secretOrKey: 'secret',
};
// opts.issuer = 'accounts.examplesoft.com';
// opts.audience = 'yoursite.net';

const Passport = (passport: any): any => {
    return passport.use(
        new JwtStrategy(opts, (jwtPayload, done) => {
            Users.findAll({ where: { id: jwtPayload.id } })
                .then(user => {
                    if (user.length) {
                        return done(null, user);
                    }
                    return done(null, false);
                })
                .catch(err => console.log(err));
        })
    );
};

export default Passport;
